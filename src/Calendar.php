<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

class Calendar extends Base
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
     * 校历筛选项
     * @return array[]
     * @throws Exception
     */
    public function calencarOptions(): array
    {
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        $html = $this->httpGet('/jsxsd/jxzl/jxzl_query', $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatCalendarOptions($html['data']);
    }

    /**
     * 解析匹配校历学期选项列表
     * @param string $html
     * @return array[]
     * @throws Exception
     */
    public function formatCalendarOptions(string $html): array
    {
        $html = $this->stripBlankspace($html);

        $semesterOptions = [];
        preg_match_all('/<option.*?>(.*?)<\/option>/', $html, $semesterNames);
        preg_match_all('/<option value="(.*?)"/', $html, $semesterValues);
        $semesterNames = $semesterNames[1] ?: [];
        $semesterValues = $semesterValues[1] ?: [];
        if (count($semesterNames) !== count($semesterValues)) throw new Exception('匹配学期选项列表异常');
        foreach ($semesterNames as $index => $semesterName) {
            $semesterOptions[] = ['name' => $semesterName, 'value' => $semesterValues[$index]];
        }

        return ['semester' => $semesterOptions];
    }

    /**
     * 请求获取学期教学周历
     * @param string $semester
     * @return array
     * @throws Exception
     */
    public function calendar(string $semester = ''): array
    {
        $url = '/jsxsd/jxzl/jxzl_query';
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        if ($semester !== '') {
            $post = "xnxq01id={$semester}";
            $referer = $this->edusysUrl . $url;
            $html = $this->httpPost($url, $post, $this->cookie, $referer);
        } else {
            $html = $this->httpGet($url, $this->cookie, $referer);
        }

        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');

        return $this->formatCalendar($html['data']);
    }

    /**
     * 解析匹配教学周历
     * @param string $html
     * @return array
     */
    public function formatCalendar(string $html): array
    {
        $html = $this->stripBlankspace($html);

        preg_match('/>(\d{4}.*?)教学周历<?/', $html, $title);
        $title = $title ? $this->stripHtmlTagAndBlankspace($title[1]) : '';

        preg_match('/<option value="(.*?)".*?selected">/', $html, $selectedValue);
        $selectedValue = $selectedValue ? $selectedValue[1] : '';
        preg_match('/selected">(.*?)<\/option>/', $html, $selectedName);
        $selectedName = $selectedName ? $selectedName[1] : '';

        preg_match_all('/<td title=\'(.*?)\'>/', $html, $allDays);
        $allDays = $allDays ? $allDays[1] : [];

        preg_match_all('/<textarea.*?>(.*?)<\/textarea>/', $html, $weekRemarks);
        $weekRemarks = $weekRemarks ? $weekRemarks[1] : [];

        preg_match_all('/<td>(.*?)<\/td>/', $html, $weekTitles);
        $weekTitles = $weekTitles ? $weekTitles[1] : [];

        preg_match('/<td>周历编制(.*?)<\/table?/', $html, $tips);
        $tips = $tips ? $this->stripHtmlTagAndBlankspace($tips[1]) : '';

        $weeks = [];
        $weekIndex = 0;
        foreach ($allDays as $index => $allDay) {
            $calendarDay = date_parse_from_format('Y年m月d', $allDay);
            $day = date('Y-m-d', mktime(0, 0, 0, $calendarDay['month'], $calendarDay['day'], $calendarDay['year']));
            $weeks[$weekIndex]['items'][] = $day;
            if ((7 * ($weekIndex + 1)) - 1 === $index) {
                $weeks[$weekIndex]['remarks'] = $weekRemarks[$weekIndex];
                $weeks[$weekIndex]['title'] = $weekTitles[$weekIndex];
                $weekIndex++;
            }
        }

        return [
            'title'    => $title,
            'selected' => ['name' => $selectedName, 'value' => $selectedValue],
            'weeks'    => $weeks,
            'tips'     => $tips
        ];
    }

}