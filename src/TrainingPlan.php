<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 培养方案
 */
class TrainingPlan extends Base
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
     * 获取培养方案
     * @return array
     * @throws Exception
     */
    public function trainingPlan(): array
    {
        if ($this->isTeacher($this->usercode)) throw new Exception('教师不适用培养计划');
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        $html = $this->httpGet('/jsxsd/pyfa/topyfamx', $this->cookie, $referer);
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取培养计划失败');
        return $this->formatTrainingPlan($html['data']);
    }

    /**
     * 正则匹配解析培养方案内容
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatTrainingPlan(string $html): array
    {
        $title = '';           // 标题
        $cultivateTarget = ''; // 培养目标
        $description = '';      // 详细说明

        preg_match('/<caption.*?>(.*?)<\/caption>/', $html, $title);
        $title = $title[1] ?? '';

        preg_match('/培养目标.*?left">(.*?)<\//s', $html, $cultivateTarget);
        $cultivateTarget = $cultivateTarget[1] ?? '';

        preg_match('/详细说明.*?left">(.*?)<\//s', $html, $description);
        $description = $description[1] ?? '';

        // 学期进度
        preg_match('/<select id="xnxq".*?<\/select>/s', $html, $termProgressHtml);
        $termProgressHtml = $termProgressHtml[0] ?? '';
        $termProgress = $this->formatOption($termProgressHtml, '', '/value="(.*?)"/');
        foreach ($termProgress as $index => $item) {
            $termProgress[$index]['term'] = $item['name'];
            $termProgress[$index]['progress'] = $item['value'];
            unset($termProgress[$index]['name']);
            unset($termProgress[$index]['value']);
            unset($termProgress[$index]['checked']);
        }

        // 课程体系小计
        preg_match_all('/小计.*?<\/TR>/s', $html, $courseSystemSummaryHtmls);
        $courseSystemSummaryHtmls = $courseSystemSummaryHtmls[0] ?? [];

        // summary 累加变量
        $summaryCredit = 0;
        $summaryLectureHours = 0;
        $summaryExperimentalHours = 0;
        $summaryDesignHours = 0;
        $summaryComputerHours = 0;
        $summaryOtherHours = 0;
        $summaryPracticalHours = 0;
        $summaryTotalHours = 0;

        // 培养方案表格
        $content = [];
        preg_match_all('/<TR.*?<TD.*?rowspan.*?小计/s', $html, $courseSystems);
        if (!isset($courseSystems[0])) throw new Exception('获取培养方案表异常');
        // 课程体系遍历
        foreach ($courseSystems[0] as $index => $courseSystem) {
            if (strpos($courseSystem, 'logic:iterate') !== false) continue; // 教务系统HTML注释掉的无效数据
            preg_match('/>(.*?)<br>\(应修/', $courseSystem, $courseSystemTitle);
            preg_match('/应修(.*?)\//', $courseSystem, $due);
            preg_match('/已修(.*?)\)<\//', $courseSystem, $existing);
            $courseSystemTitle = $courseSystemTitle[1] ? $this->stripBlankspace($courseSystemTitle[1]) : '';
            $due = $due[1] ? $this->stripBlankspace($due[1]) : '';
            $existing = $existing[1] ? $this->stripBlankspace($existing[1]) : '';
            $content[$index]['courseSystem'] = [
                'title' => $courseSystemTitle, // 课程体系名称
                'due' => $due,               // 课程体系应修
                'existing' => $existing           // 课程体系已修
            ];

            // 课程体系小计
            preg_match_all('/<TD.*?>(.*?)<\/TD>/', $courseSystemSummaryHtmls[$index], $courseSystemSummaryTd);
            $courseSystemSummaryTd = $courseSystemSummaryTd[1] ?? [];
            $content[$index]['summary'] = [
                'credit' => $this->stripBlankspace($courseSystemSummaryTd[0]),
                'lectureHours' => $this->stripBlankspace($courseSystemSummaryTd[1]),
                'experimentalHours' => $this->stripBlankspace($courseSystemSummaryTd[2]),
                'designHours' => $this->stripBlankspace($courseSystemSummaryTd[3]),
                'computerHours' => $this->stripBlankspace($courseSystemSummaryTd[4]),
                'otherHours' => $this->stripBlankspace($courseSystemSummaryTd[5]),
                'practicalHours' => $this->stripBlankspace($courseSystemSummaryTd[6]),
                'totalHours' => $this->stripBlankspace($courseSystemSummaryTd[7]),
            ];

            // 课程体系所含课程
            preg_match_all('/<TR>.*?<TD(.*?)<\/TD>.*?<\/TR>/s', $courseSystem, $courseHtmls);
            if (!isset($courseHtmls[0])) continue;
            foreach ($courseHtmls[0] as $courseHtml) {
                preg_match_all('/<TD.*?>(.*?)<\/TD>/', $courseHtml, $tds);
                $tds = $tds[1] ?? [];
                $tds = array_filter($tds, function ($item) { // 移除跨列的“课程体系”单元格
                    return !(strpos($item, '应修') !== false);
                });
                $tds = array_values($tds); // 键名重新从0开始排序
                $group = $this->stripBlankspace($tds[0]); // 选课组
                $courseCode = $this->stripBlankspace($tds[1]); // 课程编号
                $courseName = $this->stripBlankspace($tds[2]); //课程名称
                $completion = null; // 完成情况
                if (!empty($this->stripHtmlTagAndBlankspace($tds[3]))) {
                    preg_match('/(.*?)\(/', $tds[3], $status);
                    preg_match('/\((\d+)\)/', $tds[3], $score);
                    $status = $status[1] ?? '';
                    $score = $score[1] ?? '';
                    if (strpos($this->stripHtmlTagAndBlankspace($tds[3]), '已修不及格') !== false) {
                        $completion['status'] = '已修不及格';
                    }
                    $completion = [
                        'status' => $status,
                        'score' => $score
                    ];
                }
                $courseNature = $this->stripBlankspace($tds[4]);          // 课程性质
                $courseType = $this->stripBlankspace($tds[5]);            // 课程属性
                $credit = $this->stripBlankspace($tds[6]);                // 学分
                $lectureHours = $this->stripBlankspace($tds[7]);          // 讲课学时
                $experimentalHours = $this->stripBlankspace($tds[8]);     // 实验学时
                $designHours = $this->stripBlankspace($tds[9]);           // 设计学时
                $computerHours = $this->stripBlankspace($tds[10]);        // 上机学时
                $otherHours = $this->stripBlankspace($tds[11]);           // 其他学时
                $practicalHours = $this->stripBlankspace($tds[12]);       // 实践学时
                $totalHours = $this->stripHtmlTagAndBlankspace($tds[13]); // 总学时
                $term = $this->stripBlankspace($tds[14]);                 // 开设学期
                $content[$index]['items'][] = [
                    'group' => $group,
                    'courseCode' => $courseCode,
                    'courseName' => $courseName,
                    'completion' => $completion,
                    'courseNature' => $courseNature,
                    'courseType' => $courseType,
                    'credit' => $credit,
                    'lectureHours' => $lectureHours,
                    'experimentalHours' => $experimentalHours,
                    'designHours' => $designHours,
                    'computerHours' => $computerHours,
                    'otherHours' => $otherHours,
                    'practicalHours' => $practicalHours,
                    'totalHours' => $totalHours,
                    'term' => $term
                ];
                $summaryCredit += floatval($credit);
                $summaryLectureHours += floatval($lectureHours);
                $summaryExperimentalHours += floatval($experimentalHours);
                $summaryDesignHours += floatval($designHours);
                $summaryComputerHours += floatval($computerHours);
                $summaryOtherHours += floatval($otherHours);
                $summaryPracticalHours += floatval($practicalHours);
                $summaryTotalHours += floatval($totalHours);
            }
        }

        // 总表合计
        $summary = [
            'termProgress' => $termProgress,
            'credit' => $summaryCredit,
            'lectureHours' => $summaryLectureHours,
            'experimentalHours' => $summaryExperimentalHours,
            'designHours' => $summaryDesignHours,
            'computerHours' => $summaryComputerHours,
            'otherHours' => $summaryOtherHours,
            'practicalHours' => $summaryPracticalHours,
            'totalHours' => $summaryTotalHours
        ];

        return [
            'title' => $title,
            'cultivateTarget' => $cultivateTarget, // 培养目标
            'description' => $description,           // 详细说明
            'courseList' => [
                'content' => $content,
                'summary' => $summary
            ]
        ];
    }

    /**
     * 教师查询培养方案筛选项
     * @param string $college 院系
     * @param string $grade 年级
     * @param string $profession 专业
     * @return array
     * @throws Exception
     */
    public function options(string $college = '', string $grade = '', string $profession = ''): array
    {
        if ($this->isStudent($this->usercode)) throw new Exception('仅适用于教师账号');
        $postString = "xsyx={$college}&xsnj={$grade}&xszy={$profession}";
        $html = $this->httpPost('/jsxsd/jspyfa/pyfa_find', $postString, $this->cookie);
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('教师查询培养方案筛选项失败');
        return $this->formatTrainingPlanOptions($html['data']);
    }

    /**
     * 正则解析匹配培养方案筛选项
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatTrainingPlanOptions(string $html): array
    {
        preg_match('/院系名称.*?所在年级/s', $html, $collegeHtml);
        $collegeHtml = $collegeHtml[0] ?? '';
        $college = $this->formatOption($collegeHtml, '/>(.*?)<\/option>/', '/value="(.*?)">/',  '/<option(.*?)<\/option>/');

        preg_match('/所在年级.*?专业名称/s', $html, $gradeHtml);
        $gradeHtml = $gradeHtml[0] ?? '';
        $grade = $this->formatOption($gradeHtml, '/>(.*?)<\/option>/', '/value="(.*?)">/',  '/<option(.*?)<\/option>/');

        preg_match('/专业名称.*?查询/s', $html, $professionHtml);
        $professionHtml = $professionHtml[0] ?? '';
        $profession = $this->formatOption($professionHtml, '/>(.*?)<\/option>/', '/value="(.*?)">/',  '/<option(.*?)<\/option>/');

        return [
            'college' => $college,
            'grade' => $grade,
            'profession' => $profession
        ];
    }

    /**
     * 专业培养方案
     * @param string $grade 年级
     * @param string $profession 专业
     * @param int $page 页码
     * @return array
     * @throws Exception
     */
    public function professionTrainingPlan(string $grade, string $profession, int $page = 1): array
    {
        if ($this->isStudent($this->usercode)) throw new Exception('仅适用于教师账号');
        if (empty($grade) || empty($profession)) throw new Exception('年级或专业不能为空');
        $postString = "xsnj={$grade}&xszy={$profession}&pageIndex={$page}";
        $html = $this->httpPost('/jsxsd/jspyfa/zypyfa_query', $postString, $this->cookie);
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('教师查询培养方案筛失败');
        return $this->formatProfessionTrainingPlan($html['data']);
    }

    /**
     * 正则解析匹配专业培养方案
     * @param string $html
     * @return array
     */
    public function formatProfessionTrainingPlan(string $html): array
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
            preg_match_all('/<td.*?>(.*?)<\/td>/', $tr, $tds);
            $tds = $tds[1] ?? '';
            $courses[] = [
                'no' => strlen($tds[0]) ? $this->stripHtmlTagAndBlankspace($tds[0]) : '',                   // 序号
                'term' => strlen($tds[1]) ? $this->stripHtmlTagAndBlankspace($tds[1]) : '',                 // 开设学期
                'profession' => strlen($tds[2]) ? $this->stripHtmlTagAndBlankspace($tds[2]) : '',           // 专业名称
                'courseCode' => strlen($tds[3]) ? $this->stripHtmlTagAndBlankspace($tds[3]) : '',           // 课程编号
                'courseName' => strlen($tds[4]) ? $this->stripHtmlTagAndBlankspace($tds[4]) : '',           // 课程名称
                'totalHours' => strlen($tds[5]) ? $this->stripHtmlTagAndBlankspace($tds[5]) : '',           // 总学时
                'credit' => strlen($tds[6]) ? $this->stripHtmlTagAndBlankspace($tds[6]) : '',               // 学分
                'accessMethod' => strlen($tds[7]) ? $this->stripHtmlTagAndBlankspace($tds[7]) : '',         // 考核方式
                'department' => strlen($tds[8]) ? $this->stripHtmlTagAndBlankspace($tds[8]) : '',           // 开课单位
                'referenceWeeklyHours' => strlen($tds[9]) ? $this->stripBlankspace($tds[9]) : '', // 参考周学时
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

}