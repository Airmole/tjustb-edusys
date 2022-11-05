<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 成绩查询
 */
class Score extends Base
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
    }

    /**
     * 获取成绩
     * @param string $time 开课学期
     * @param string $nature 课程性质
     * @param string $course 课程名称
     * @param string $show 显示方式：all-显示全部成绩,max-显示最好成绩
     * @param bool $classify 是否按学期分类计算平均分
     * @return array
     * @throws Exception
     */
    public function score(
        string $time = '',
        string $nature = '',
        string $course = '',
        string $show = 'all',
        bool   $classify = true
    ): array
    {
        $referer = $this->edusysUrl . '/jsxsd/kscj/cjcx_query';
        $post = "kksj={$time}&kcxz={$nature}&kcmc={$course}&xsfs={$show}";
        $score = $this->httpPost('/jsxsd/kscj/cjcx_list', $post, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($score['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($score['code'] !== self::CODE_SUCCESS) throw new Exception('获取成绩失败');
        $summary = $this->formatScoreSummary($score['data']);
        $score = $this->formatScoreList($score['data']);
        // 按学期倒序分类并计算加权、平均分
        if ($classify) $score = $this->analyseScoreList($score);
        return ['summary' => $summary, 'data' => $score];
    }

    /**
     * 匹配解析成绩汇总信息
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatScoreSummary(string $html): array
    {
        $summaries = [];
        $simpleHtml = $this->stripBlankspace($html);

        $hasRegisterAlert = strpos($html, '已启用注册状态控制，状态已受控制,不能查询成绩！');
        if ($hasRegisterAlert) throw new Exception('启用注册状态控制，无法查询');

        if (strpos($html, '未查询到数据')) return $summaries;

        preg_match('/所修门数:(.*)?所修总学分/', $simpleHtml, $courseNum);
        $courseNum = $courseNum[1] ?? '';

        preg_match('/所修总学分:(.*)?平均学分绩点/', $simpleHtml, $creditSum);
        $creditSum = $creditSum[1] ?? '';

        preg_match('/平均学分绩点:(.*)?平均成绩/', $simpleHtml, $gpaAvg);
        $gpaAvg = $gpaAvg[1] ?? '';

        preg_match('/平均成绩:(.*)?/', $html, $scoreAvg);
        $scoreAvg = $scoreAvg[1] ?? '';

        $summaries = [
            'courseNum' => $courseNum,
            'creditSum' => $creditSum,
            'gpaAvg'    => $gpaAvg,
            'scoreAvg'  => $scoreAvg
        ];

        foreach ($summaries as $index => $summary) {
            $summaries[$index] = $this->stripHtmlTagAndBlankspace($summary);
        }

        return $summaries;
    }

    /**
     * 解析匹配成绩列表
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatScoreList(string $html): array
    {
        $score = [];
        $simpleHtml = $this->stripBlankspace($html);

        $hasRegisterAlert = strpos($html, '已启用注册状态控制，状态已受控制,不能查询成绩！');
        if ($hasRegisterAlert) throw new Exception('启用注册状态控制，无法查询');
        if (strpos($html, '未查询到数据')) return $score;

        // 行
        preg_match_all('/<tr>.*?<\/tr>/', $simpleHtml, $rowHtmls);
        $rowHtmls = $rowHtmls[0] ?? [];
        // 移除标题行并重置序号
        if (count($rowHtmls) > 0) {
            unset($rowHtmls[0]);
            $rowHtmls = array_values($rowHtmls);
        }

        $data = [];
        foreach ($rowHtmls as $index => $rowHtml) {
            preg_match_all("/<td.*?<\/td>/", $rowHtml, $cell);
            $cell = $cell[0] ?? '';
            $data[$index] = $cell;
        }

        // 语义化array结构
        foreach ($data as $row => $cells) {
            foreach ($cells as $index => $cell) {
                $data[$row][$index] = $this->stripHtmlTagAndBlankspace($cell);
            }
            $rowData = $data[$row];
            $score[$row]["SerialNo"] = $rowData[0];
            $score[$row]["courseSemester"] = $rowData[1];
            $score[$row]["courseCode"] = $rowData[2];
            $score[$row]["courseName"] = $rowData[3];
            $score[$row]["groupName"] = $rowData[4];
            $score[$row]["score"] = $rowData[5];
            $score[$row]["scoreMark"] = $rowData[6];
            $score[$row]["credit"] = $rowData[7];
            $score[$row]["period"] = $rowData[8];
            $score[$row]["scorePoint"] = $rowData[9];
            $score[$row]["refixTream"] = $rowData[10];
            $score[$row]["accessMethod"] = $rowData[11];
            $score[$row]["examNature"] = $rowData[12];
            $score[$row]["courseType"] = $rowData[13];
            $score[$row]["courseNature"] = $rowData[14];
            $score[$row]["courseCategory"] = $rowData[15];
        }

        return $score;
    }

    /**
     * 分析计算成绩列表
     *
     * 按学期倒序分类并计算每学期加权、平均分
     * @param array $score
     * @return array
     */
    public function analyseScoreList(array $score = []): array
    {
        $result = [];
        if (empty($score)) return $result;
        // 倒序，最近新出的成绩排在最前
        $score = array_reverse($score);

        // 所有学期
        $semesters = []; // 学期
        foreach ($score as $item) {
            if (in_array($item['courseSemester'], $semesters)) continue;
            $semesters[] = $item['courseSemester'];
        }

        // 按学期分类的成绩列表
        $semesterScore = [];
        foreach ($score as $item) {
            foreach ($semesters as $semester) {
                if ($item['courseSemester'] != $semester) continue;
                $semesterScore[$semester]["items"][] = $item;
            }
        }

        foreach ($semesters as $semester) {
            $semesterScoreTotal = 0;
            $semesterScoreCreditSum = 0;
            $semesterSumCredit = 0;
            $semesterSumVaild = 0;
            foreach ($semesterScore[$semester]["items"] as $key => $value) {
                $courseScore = $semesterScore[$semester]["items"][$key]['score'];
                // 60分以上计入计算加权平均分
                if (is_numeric($courseScore) && (int)$courseScore >= 60) {
                    $semesterSumVaild = $semesterSumVaild + 1;
                    $semesterScoreTotal = $semesterScoreTotal + (int)$courseScore;
                    $credit = is_numeric($value['credit']) ? $value['credit'] : sprintf("%01.2f", (float)$value['credit']);
                    $semesterScoreCreditSum = $semesterScoreCreditSum + ((int)$courseScore * $credit);
                    $semesterSumCredit = $semesterSumCredit + $value['credit'];
                }
            }
            $semesterScore[$semester]["total"] = $semesterScoreTotal;
            if ($semesterSumVaild == 0) $semesterSumVaild = 1;
            if ($semesterSumCredit == 0) $semesterSumCredit = 1;
            // 学期平均分
            $avg = sprintf("%01.2f", $semesterScoreTotal / $semesterSumVaild);
            // 学期加权分
            $gpa = sprintf("%01.2f", $semesterScoreCreditSum / $semesterSumCredit);
            $semesterScore[$semester]["avg"] = $avg;
            $semesterScore[$semester]["gpa"] = $gpa;
            // 学期
            $semesterScore[$semester]["semester"] = $semester;
        }

        return $semesterScore;
    }

    /**
     * 获取成绩查询筛选菜单列表
     * @return array[]
     * @throws Exception
     */
    public function scoreQueryOptions(): array
    {
        $referer = $this->edusysUrl . '/jsxsd/kscj/cjcx_frm';
        $html = $this->httpGet('/jsxsd/kscj/cjcx_query', $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatScoreQueryOptions($html['data']);
    }

    /**
     * 匹配成绩查询筛选下拉选项菜单
     * @param string $html
     * @return array[]
     * @throws Exception
     */
    public function formatScoreQueryOptions(string $html): array
    {
        // 考试时间选项列表
        $timeOptions = [];
        preg_match('/开课时间.*?课程性质/s', $html, $timelistHtml);
        $timelistHtml = $timelistHtml ? $timelistHtml[0] : '';
        preg_match_all('/>(.*)?<\/option>/', $timelistHtml, $timeNames);
        preg_match_all('/<option value="(.*)?"/', $timelistHtml, $timeValues);
        $timeNames = $timeNames[1] ?: [];
        $timeValues = $timeValues[1] ?: [];
        if (count($timeNames) !== count($timeValues)) throw new Exception('匹配考试时间选项列表异常');
        foreach ($timeNames as $index => $timeName) {
            $timeOptions[] = ['name' => $timeName, 'value' => $timeValues[$index]];
        }

        // 课程性质选项列表
        $natureOptions = [];
        preg_match('/课程性质.*?课程名称/s', $html, $natureHtml);
        $natureHtml = $natureHtml ? $natureHtml[0] : '';
        preg_match_all('/>(.*)?<\/option>/', $natureHtml, $natureNames);
        preg_match_all('/<option value="(.*)?"/', $natureHtml, $natureValues);
        $natureNames = $natureNames[1] ?: [];
        $natureValues = $natureValues[1] ?: [];
        if (count($natureNames) !== count($natureValues)) throw new Exception('匹配课程性质选项列表异常');
        foreach ($natureNames as $index => $natureName) {
            $natureOptions[] = ['name' => $natureName, 'value' => $natureValues[$index]];
        }

        // 显示方式选项列表
        $showOptions = [];
        preg_match('/显示方式.*?是否显示补重成绩/s', $html, $showHtml);
        $showHtml = $showHtml ? $showHtml[0] : '';
        preg_match_all('/>(.*)?<\/option>/', $showHtml, $showNames);
        preg_match_all('/<option value="(.*)?"/', $showHtml, $showValues);
        $showNames = $showNames[1] ?: [];
        $showValues = $showValues[1] ?: [];
        if (count($showNames) !== count($showValues)) throw new Exception('匹配显示方式选项列表异常');
        foreach ($showNames as $index => $showName) {
            $showOptions[] = ['name' => $showName, 'value' => $showValues[$index]];
        }

        return [
            'time'   => $timeOptions,
            'nature' => $natureOptions,
            'show'   => $showOptions
        ];
    }

}