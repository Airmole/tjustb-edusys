<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

class classCourseTable extends Base
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
        if (empty($this->usercode)) throw new Exception('学号参数不得为空');
    }

    /**
     * 查询选项列表
     * @return array
     * @throws Exception
     */
    public function options(): array
    {
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        $html = $this->httpGet('/jsxsd/kbcx/kbxx_xzb', $this->cookie, $referer, 50);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatOptions($html['data']);
    }

    /**
     * 匹配解析选项列表
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatOptions(string $html): array
    {
        // 学年学期选项列表
        preg_match('/学年学期.*?时间模式/s', $html, $semesterlistHtml);
        $semesterlistHtml = $semesterlistHtml ? $semesterlistHtml[0] : '';
        $semesterOptions = $this->formatOption($semesterlistHtml);
        // 时间模式
        preg_match('/时间模式.*?上课院系/s', $html, $timeModelHtml);
        $timeModelHtml = $timeModelHtml ? $timeModelHtml[0] : '';
        $timeModelOptions = $this->formatOption($timeModelHtml);
        // 上课院系
        preg_match('/上课院系.*?上课年级/s', $html, $collegeHtml);
        $collegeHtml = $collegeHtml ? $collegeHtml[0] : '';
        $collegeOptions = $this->formatOption($collegeHtml, '', '/<option value="(.*)?"/');
        // 上课年级
        preg_match('/上课年级.*?上课专业/s', $html, $gradeHtml);
        $gradeHtml = $gradeHtml ? $gradeHtml[0] : '';
        $gradeOptions = $this->formatOption($gradeHtml, '', '/<option value="(.*)?"/');

        return [
            'semester' => $semesterOptions,
            'timeModel' => $timeModelOptions,
            'college' => $collegeOptions,
            'grade' => $gradeOptions
        ];
    }

    /**
     * 匹配解析某下拉列表值
     * @param string $html
     * @param string $namePattern
     * @param string $valuePattern
     * @return array
     * @throws Exception
     */
    public function formatOption(string $html, string $namePattern = '', string $valuePattern = ''): array
    {
        $result = [];
        $namePattern = $namePattern === '' ? '/>(.*)?<\/option>/' : $namePattern;
        $valuePattern = $valuePattern === '' ? '/<option value="(.*)?" /' : $valuePattern;
        preg_match_all($namePattern, $html, $names);
        preg_match_all($valuePattern, $html, $values);
        $names = $names ? $names[1] : [];
        $values = $values ? $values[1] : [];
        if (count($names) !== count($values)) throw new Exception('匹配模式选项列表异常');
        foreach ($names as $index => $name) {
            $checked = $index === 0;
            $result[] = ['name' => $name, 'value' => $values[$index], 'checked' => $checked];
        }
        return $result;
    }

    /**
     * 获取院系专业列表
     * @param string $collegeCode 院系代码
     * @param string $grade
     * @return array
     */
    public function getProfessionsByCollege(string $collegeCode = '', string $grade = ''): array
    {
        $data = [];
        $query = "&skyx={$collegeCode}&sknj={$grade}";
        $url = '/jsxsd/kbcx/getZyByAjax?' . $query;
        $referer = $this->edusysUrl . '/jsxsd/kbcx/kbxx_xzb';
        $jsonStr = $this->httpGet($url, $this->cookie, $referer);
        $json = json_decode($jsonStr['data'], true);
        if (is_array($json)) $data = $json;
        return $data;
    }
}