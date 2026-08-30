<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 教师账号相关功能
 */
class Teacher extends AbstractService
{
    /**
     * @var string 账号参数校验失败时的错误消息
     */
    protected string $usercodeEmptyMessage = '账号参数不得为空';

    /**
     * 查询我的课程列表
     * @return array
     * @throws Exception
     */
    public function courseList(): array
    {
        $url = '/jsxsd/framework/jsMain_new.jsp?t1=1';
        $referer = $this->edusysUrl . '/jsxsd/framework/jsMain.jsp';
        $html = $this->httpGet($url, $this->cookie, $referer);
        $this->validateHtml($html['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatCourseList($html['data']);
    }

    /**
     * 匹配解析我的课程列表
     * @param string $html
     * @return array
     */
    public function formatCourseList(string $html): array
    {
        preg_match_all('/list-group-item.*?&nbsp;/s', $html, $courseListHtmls);
        $courseListHtmls = $courseListHtmls ? $courseListHtmls[0] : [];

        $courses = [];
        foreach ($courseListHtmls as $courseListHtml) {
            preg_match('/title="(.*?)"/', $courseListHtml, $title);
            $title = $title ? $title[1] : '';

            preg_match('/>课堂名称：(.*?)</', $courseListHtml, $className);
            $className = $className ? $className[1] : '';

            preg_match('/frdy_laosha\(\'(.*?)\'/', $courseListHtml, $queryCode);
            $queryCode = $queryCode ? $queryCode[1] : '';
            $courses[] = [
                'title' => $title,
                'className' => $className,
                'queryCode' => $queryCode,
            ];
        }

        return $courses;
    }

    /**
     * 查询学生花名册
     * @param string $queryCode
     * @return array
     * @throws Exception
     */
    public function queryStudentList(string $queryCode): array
    {
        if (empty($queryCode)) throw new Exception('查询码不得为空');
        $referer = $this->edusysUrl . '/jsxsd/framework/jsMain.jsp';
        $url = "/jsxsd/framework/jsMain_hmc.jsp?jx0404id={$queryCode}";

        $html = $this->httpGet($url, $this->cookie, $referer);
        $this->validateHtml($html['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatStudentList($html['data']);
    }

    /**
     * 匹配解析学生花名册
     * @param string $html
     * @return array
     */
    public function formatStudentList(string $html): array
    {
        preg_match_all('/<tr>(.*?)<\/tr>/s', $html, $rows);
        $rows = $rows ? $rows[0] : [];

        $fieldMap = ['no', 'major', 'profession', 'grade', 'className', 'usercode', 'name', 'gender'];

        $studentList = [];
        foreach ($rows as $index => $row) {
            if ($index == 0) continue;
            $tempArray = explode("</td>", $row);
            $student = [];
            foreach ($fieldMap as $fieldIndex => $fieldName) {
                $student[$fieldName] = isset($tempArray[$fieldIndex])
                    ? $this->stripHtmlTagAndBlankspace($tempArray[$fieldIndex])
                    : '';
            }
            $studentList[] = $student;
        }

        return $studentList;
    }
}
