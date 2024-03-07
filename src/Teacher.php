<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 教师账号相关功能
 */
class Teacher extends Base
{
    /**
     * 初始化
     * @throws Exception
     */
    public function __construct(string $usercode = '', string $cookie = '')
    {
        parent::__construct();
        $this->cookie = $cookie;
        $this->usercode = $usercode;
        if (empty($this->cookie)) throw new Exception('cookie不得为空');
        if (empty($this->usercode)) throw new Exception('账号参数不得为空');
    }

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
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
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
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
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
        preg_match_all('/<tr>(.*?)<\/tr>/s',$html,$rows);
        $rows = $rows ? $rows[0] : [];

        $studentList = [];
        foreach ($rows as $index => $row) {
            if ($index == 0) continue;
            $tempArray = explode("</td>",$row);
            $studentList[] = [
                'no' => $this->stripHtmlTagAndBlankspace($tempArray[0]),
                'major' => $this->stripHtmlTagAndBlankspace($tempArray[1]),
                'profession' => $this->stripHtmlTagAndBlankspace($tempArray[2]),
                'grade' => $this->stripHtmlTagAndBlankspace($tempArray[3]),
                'className' => $this->stripHtmlTagAndBlankspace($tempArray[4]),
                'usercode' => $this->stripHtmlTagAndBlankspace($tempArray[5]),
                'name' => $this->stripHtmlTagAndBlankspace($tempArray[6]),
                'gender' => $this->stripHtmlTagAndBlankspace($tempArray[7]),
            ];
        }

        return $studentList;
    }

}