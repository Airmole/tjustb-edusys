<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 学生评教
 */
class EvaluateTeacher extends Base
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
     * 获取需评教学期批次
     * @return array
     * @throws Exception
     */
    public function needEvaluateSemester(): array
    {
        if (!$this->isStudent($this->usercode)) throw new Exception('评教仅适用于学生用户');
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        $html = $this->httpGet('/jsxsd/xspj/xspj_find.do', $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取评教学期批次失败');
        return $this->formatEvaluateSemester($html['data']);
    }

    /**
     * 正则匹配需评教学期批次列表
     * @param string $html
     * @return array
    */
    public function formatEvaluateSemester(string $html): array
    {
        preg_match('/value=\"(.*?)\" id=\"pageIndex\"/', $html, $currentPage);
        $currentPage = $currentPage[1] ? intval($currentPage[1]) : 1;

        preg_match('/<span> 共(\d+)页&nbsp;\d+条<\/span>/', $html, $totalPage);
        $totalPage = $totalPage[1] ? intval($totalPage[1]) : 0;

        preg_match('/<span> 共\d+页&nbsp;(\d+)条<\/span>/', $html, $total);
        $total = $total[1] ? intval($total[1]) : 0;

        preg_match_all('/<tr>\s+<td>.*?<\/td>\s+<\/tr>/s', $html, $trs);
        $trs = $trs[0] ?? [];

        $semesters = [];
        foreach ($trs as $tr) {
            preg_match_all('/<td.*?>(.*?)<\/td>/s', $tr, $tds);
            $tds = $tds[1] ?? [];
            if (empty($tds)) continue;
            preg_match('/href=\"(.*?)\" title=\"点击进入评价\">进入评价<\/a>/', $tds[6], $url);

            $no = $this->stripHtmlTagAndBlankspace($tds[0]);            // 序号
            $semester = $this->stripHtmlTagAndBlankspace($tds[1]);      // 学年学期
            $evaluateCategory = $this->stripHtmlTagAndBlankspace($tds[2]);  // 评价分类
            $evaluateBatch = $this->stripHtmlTagAndBlankspace($tds[3]); // 评价批次
            $startAt = $this->stripHtmlTagAndBlankspace($tds[4]);       // 开始时间
            $endAt = $this->stripHtmlTagAndBlankspace($tds[5]);         // 结束时间
            $url = $url[1] ?? '';                                       // 进入评教链接

            $semesters[] = [
                'no' => $no,
                'semester' => $semester,
                'evaluateType' => $evaluateCategory,
                'evaluateBatch' => $evaluateBatch,
                'startAt' => $startAt,
                'endAt' => $endAt,
                'url' => $url
            ];
        }

        return [
            'data' => $semesters,
            'pagination' => [
                'total' => $total,
                'currentPage' => $currentPage,
                'totalPage' => $totalPage,
            ]
        ];
    }

    /**
     * 获取评教课程列表
     * @param string $semesterUrl 评教学期批次页面URL
     * @throws Exception
     */
    public function needEvaluateCourse(string $semesterUrl): array
    {
        if (empty($semesterUrl)) throw new Exception('评教学期URL入口有误');
        $referer = $this->edusysUrl . '/jsxsd/xspj/xspj_find.do';
        $html = $this->httpGet($semesterUrl, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取评教课程列表失败');
        return $this->formatEvaluateCourseList($html['data']);
    }

    /**
     * 正则匹配评教课程列表
     * @param string $html
     * @return array
    */
    public function formatEvaluateCourseList(string $html): array
    {
        preg_match('/value=\"(.*?)\" id=\"pageIndex\"/', $html, $currentPage);
        $currentPage = $currentPage[1] ? intval($currentPage[1]) : 1;

        preg_match('/<span> 共(\d+)页&nbsp;\d+条<\/span>/', $html, $totalPage);
        $totalPage = $totalPage[1] ? intval($totalPage[1]) : 0;

        preg_match('/<span> 共\d+页&nbsp;(\d+)条<\/span>/', $html, $total);
        $total = $total[1] ? intval($total[1]) : 0;

        preg_match_all('/<tr>\s+<td>.*?<\/td>\s+<\/tr>/s', $html, $trs);
        $trs = $trs[0] ?? [];

        $courses = [];
        foreach ($trs as $tr) {
            preg_match_all('/<td.*?>(.*?)<\/td>/s', $tr, $tds);
            $tds = $tds[1] ?? [];
            if (empty($tds)) continue;

            preg_match('/href=\"(.*?)\">查看<\/a>/', $tds[8], $url);
            $url = $url[1] ?? '';

            $no = $this->stripHtmlTagAndBlankspace($tds[0]);           // 序号
            $courseCode = $this->stripHtmlTagAndBlankspace($tds[1]);   // 课程编号
            $courseName = $this->stripHtmlTagAndBlankspace($tds[2]);   // 课程名称
            $teacher = $this->stripHtmlTagAndBlankspace($tds[3]);      // 授课教师
            $evaluateType = $this->stripHtmlTagAndBlankspace($tds[4]); // 评教类别
            $score = $this->stripHtmlTagAndBlankspace($tds[5]);        // 总评分
            $evaluated = $this->stripHtmlTagAndBlankspace($tds[6]);    // 已评
            $submited = $this->stripHtmlTagAndBlankspace($tds[7]);     // 是否提交
            $courses[] = [
                'no' => $no,
                'courseCode' => $courseCode,
                'courseName' => $courseName,
                'teacher' => $teacher,
                'evaluateType' => $evaluateType,
                'score' => $score,
                'evaluated' => $evaluated,
                'submited' => $submited,
                'url' => $url
            ];
        }

        return [
            'data' => $courses,
            'pagination' => [
                'total' => $total,
                'currentPage' => $currentPage,
                'totalPage' => $totalPage,
            ]
        ];
    }

    /**
     * 获取评教课程详情
     * @throws Exception
     */
    public function evaluateCourseDetail(string $courseUrl): array
    {
        if (empty($courseUrl)) throw new Exception('评教课程URL入口有误');
        $referer = $this->edusysUrl . '/jsxsd/xspj/xspj_list.do';
        $html = $this->httpGet($courseUrl, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取评教课程详情失败');
        return $this->formatEvaluateCourseDetail($html['data']);
    }

    /**
     * 正则匹配评教详情
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatEvaluateCourseDetail(string $html): array
    {
        preg_match('/课程名称：(.*?)评教大类/', $html, $courseName);
        $courseName = $courseName[1] ? $this->stripHtmlTagAndBlankspace($courseName[1]) : '';                   // 课程名称

        preg_match('/评教大类：(.+)/', $html, $evaluateCategory);
        $evaluateCategory = $evaluateCategory[1] ? $this->stripHtmlTagAndBlankspace($evaluateCategory[1]) : ''; // 评教大类

        preg_match('/总评分: (\d+)/', $html, $score);
        $score = $score[1] ? $this->stripHtmlTagAndBlankspace($score[1]) : '';                                  // 总评分

        preg_match('/<form.*?<\/form>/s', $html, $formHtml); // form表单
        $formHtml = $formHtml[0] ?? '';

        preg_match('/<input.*?<table/s', $formHtml, $paramsHtml); // hidden input参数
        $paramsHtml = $paramsHtml[0] ?? '';
        preg_match_all('/name="(.+?)"/', $paramsHtml, $paramNames);
        $paramNames = $paramNames[1] ?? [];
        preg_match_all('/value="(.*?)"/', $paramsHtml, $paramValues);
        $paramValues = $paramValues[1] ?? [];
        if (count($paramNames) !== count($paramValues)) throw new Exception('评教参数获取不匹配');
        $params = [];
        foreach ($paramNames as $index => $paramName) {
            $params[] = [ 'name' => $paramName, 'value' => $paramValues[$index] ];
        }

        preg_match('/<table.+?<\/table>/s', $formHtml, $tableHtml);
        $tableHtml = $tableHtml[0] ?? '';

        preg_match_all('/<tr>\s+<td>.*?<\/td>\s+<\/tr>/s', $tableHtml, $trHtmls);
        $trHtmls = $trHtmls[0] ?? [];

        $form = [];
        foreach ($trHtmls as $trHtml) {
            preg_match('/<tr>\s+<td>(.*?)<input/s', $trHtml, $descriptionText);
            $descriptionText = $descriptionText[1] ? $this->stripHtmlTagAndBlankspace($descriptionText[1]) : '';

            preg_match('/<input type="hidden" name="(.*?)" value=".*?">\s+<\/td>\s+<td name="zbtd">/', $trHtml, $name);
            $name = $name[1] ?? '';

            preg_match('/<input type="hidden" name=".*?" value="(.*?)">\s+<\/td>\s+<td name="zbtd">/', $trHtml, $value);
            $value = $value[1] ?? '';

            preg_match('/<td name="zbtd">.*?<\/td>/s', $trHtml, $tdHtml);
            $tdHtml = $tdHtml[0] ?? '';

            preg_match_all('/<input type="radio".*?value="\d+?">/s', $tdHtml, $optionHtmls);
            $optionHtmls = $optionHtmls[0] ?? [];

            $options = [];
            foreach ($optionHtmls as $optionHtml) {
                preg_match('/>(.*?)<input/s', $optionHtml, $text);
                $text = $text[1] ? $this->stripHtmlTagAndBlankspace($text[1]) : '';

                preg_match_all('/<input.*?>/s', $optionHtml, $inputs);
                $inputs = $inputs[0] ?? [];
                if (count($inputs) !== 2) continue;

                preg_match('/type="(.*?)"/', $inputs[0], $radioType);
                $radioType = $radioType[1] ?? '';
                preg_match('/name="(.*?)"/', $inputs[0], $radioName);
                $radioName = $radioName[1] ?? '';
                preg_match('/value="(.*?)"/', $inputs[0], $radioValue);
                $radioValue = $radioValue[1] ?? '';
                preg_match('/checked="checked"/', $inputs[0], $checked);
                $checked = isset($checked[0]);

                preg_match('/type="(.*?)"/', $inputs[1], $hiddenType);
                $hiddenType = $hiddenType[1] ?? '';
                preg_match('/name="(.*?)"/', $inputs[1], $hiddenName);
                $hiddenName = $hiddenName[1] ?? '';
                preg_match('/value="(.*?)"/', $inputs[1], $hiddenValue);
                $hiddenValue = $hiddenValue[1] ?? '';


                $options[] = [
                    'text' => $text,
                    'radio' => [
                        'type' => $radioType,
                        'name' => $radioName,
                        'value' => $radioValue,
                        'checked' => $checked
                    ],
                    'hidden' => [
                        'type' => $hiddenType,
                        'name' => $hiddenName,
                        'value' => $hiddenValue
                    ]
                ];
            }

            $description = [
                'text' => $descriptionText,
                'name' => $name,
                'value' => $value,
                'options' => $options
            ];
            $form[] = $description;

        }

        return [
            'courseName' => $courseName,
            'evaluateCategory' => $evaluateCategory,
            'score' => $score,
            'params' => $params,
            'form' => $form
        ];
    }

}