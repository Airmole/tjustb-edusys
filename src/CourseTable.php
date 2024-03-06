<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 课表
 */
class CourseTable extends Base
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
     * 课表查询选项列表
     * @return array[]
     * @throws Exception
     */
    public function myCourseQueryOptions(): array
    {
        $referer = $this->edusysUrl . ($this->isStudent($this->usercode) ? '/jsxsd/framework/xsMain.jsp' : '/jsxsd/framework/jsMain.jsp');
        $url = $this->isStudent($this->usercode) ? '/jsxsd/xskb/xskb_list.do' : '/jsxsd/jskb/jskb_list.do';
        $html = $this->httpGet($url, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatMyCourseQueryOptions($html['data']);
    }

    /**
     * 解析匹配课表查询选项列表
     * @param string $html
     * @return array[]
     * @throws Exception
     */
    public function formatMyCourseQueryOptions(string $html): array
    {
        // 周次选项列表
        $weekOptions = [];
        preg_match('/周次.*?学年学期/s', $html, $weeklistHtml);
        $weeklistHtml = $weeklistHtml ? $weeklistHtml[0] : '';
        preg_match_all('/>(.*)?<\/option>/', $weeklistHtml, $weekNames);
        preg_match_all('/<option value="(.*)?"/', $weeklistHtml, $weekValues);
        $weekNames = $weekNames[1] ?: [];
        $weekValues = $weekValues[1] ?: [];
        if (count($weekNames) !== count($weekValues)) throw new Exception('匹配周次选项列表异常');
        foreach ($weekNames as $index => $weekName) {
            $checked = $index === 0;
            $weekOptions[] = ['name' => $weekName, 'value' => $weekValues[$index], 'checked' => $checked];
        }

        // 学年学期选项列表
        $semesterOptions = [];
        preg_match('/学年学期.*?打 印/s', $html, $semesterlistHtml);
        $semesterlistHtml = $semesterlistHtml ? $semesterlistHtml[0] : '';
        preg_match_all('/>(.*)?<\/option>/', $semesterlistHtml, $semesterNames);
        preg_match_all('/<option value="(.*)?" /', $semesterlistHtml, $semesterValues);
        $semesterNames = $semesterNames[1] ?: [];
        $semesterValues = $semesterValues[1] ?: [];
        if (count($semesterNames) !== count($semesterValues)) throw new Exception('匹配学年学期选项列表异常');
        foreach ($semesterNames as $index => $semesterName) {
            $checked = $index === 0;
            $semesterOptions[] = ['name' => $semesterName, 'value' => $semesterValues[$index], 'checked' => $checked];
        }

        return ['week' => $weekOptions, 'semester' => $semesterOptions];
    }

    /**
     * 个人学期课表
     * @param string $week
     * @param string $semester
     * @return array
     * @throws Exception
     */
    public function semesterCourse(string $week = '', string $semester = ''): array
    {
        $post = "zc={$week}&xnxq01id={$semester}";
        if ($this->isStudent($this->usercode)) {
            $referer = $this->edusysUrl . '/jsxsd/xskb/xskb_list.do';
            $html = $this->httpPost('/jsxsd/xskb/xskb_list.do', $post, $this->cookie, $referer);
        } else {
            $referer = $this->edusysUrl . '/jsxsd/jskb/jskb_list.do';
            $html = $this->httpPost('/jsxsd/jskb/jskb_list.do', $post, $this->cookie, $referer);
        }
        $validHtml = $this->checkCookieByHtml($html['data']);
        if ($validHtml !== true) throw new Exception($validHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatMyCourse($html['data'], $this->isTeacher($this->usercode));
    }

    /**
     * 格式化解析匹配个人学期课表
     * @param string $html
     * @return array
     */
    public function formatMyCourse(string $html): array
    {
        // 课表table
        preg_match('/<table.*?<\/table/s', $html, $tableHtml);
        $tableHtml = $tableHtml ? $tableHtml[0] : '';

        // 当前查询周值（空字符串表示全部）
        preg_match('/周次.*?学年学期/s', $html, $weeklistHtml);
        $weeklistHtml = $weeklistHtml ? $weeklistHtml[0] : '';
        $weekValue = $this->getSelectedWeekValue($weeklistHtml);

        // 当前查询学期（默认值当前学期）
        preg_match('/学年学期.*?打 印/s', $html, $semesterlistHtml);
        $semesterlistHtml = $semesterlistHtml ? $semesterlistHtml[0] : '';
        $semesterValue = $this->getSelectedWeekValue($semesterlistHtml);

        // 表格行
        preg_match_all('/<tr.*?<\/tr>/s', $tableHtml, $trHtmls);
        $trHtmls = $trHtmls ? $trHtmls[0] : [];
        $columnsTitlesHtml = $trHtmls[0];
        unset($trHtmls[0]);
        $trHtmls = array_values($trHtmls);

        // 匹配列标题（不为空）
        preg_match_all('/<th.*?>(.*?)<\/th/', $columnsTitlesHtml, $columnTitles);
        $columnTitles = $columnTitles ? $columnTitles[1] : [];

        // 匹配行标题（不为空）
        preg_match_all('/<tr.*?th.*?>(.*?)<\/th/s', $tableHtml, $rowTitles);
        $rowTitles = $rowTitles ? $rowTitles[1] : [];
        foreach ($rowTitles as $index => $rowTitile) {
            $rowTitile = $this->stripHtmlTagAndBlankspace($rowTitile);
            if (empty($rowTitile)) {
                unset($rowTitles[$index]);
                continue;
            }
            $rowTitles[$index] = $rowTitile;
        }
        $rowTitles = array_values($rowTitles);

        // 匹配每节课
        $coursesList = [];
        foreach ($trHtmls as $trIndex => $trHtml) {
            preg_match_all('/<td.*?<\/td>/s', $trHtml, $tdHtmls);
            $tdHtmls = $tdHtmls ? $tdHtmls[0] : [];
            if (empty($tdHtmls)) continue;
            $classTime = isset($rowTitles[$trIndex]) ? (string)$rowTitles[$trIndex] : '';
            $classTime = explode('-', $classTime);
            $startAt = isset($classTime[0]) ? (string)$classTime[0] : '';
            $endAt = isset($classTime[1]) ? (string)$classTime[1] : '';
            foreach ($tdHtmls as $tdHtml) {
                $tdHtml = $this->stripBlankspace($tdHtml);
                preg_match('/kbcontent".*?<\/div/', $tdHtml, $cellHtml);
                $cellHtml = $cellHtml ? $cellHtml[0] : '';
                // 非课程单元格
                if (empty($cellHtml)) continue;
                if ($this->isStudent($this->usercode)) {
                    $coursesList[] = $this->formatStudentCellHtmlCourse($cellHtml, $startAt, $endAt);
                } else {
                    $coursesList[] = $this->formatTeacherCellHtmlCourse($cellHtml, $startAt, $endAt);
                }
            }
        }

        // 按星期分类课表
        $courses = $this->classifyCourseTableByDayOfWeek($coursesList, $columnTitles);

        // 备注
        $tips = $this->stripHtmlTagAndBlankspace(isset($trHtmls[count($trHtmls) - 1]) ? (string)$trHtmls[count($trHtmls) - 1] : '');

        return [
            'semester'    => $semesterValue,
            'week'        => $weekValue,
            'table'       => $courses,
            'columnTitle' => $columnTitles,
            'rowTitle'    => $rowTitles,
            'tips'        => $tips
        ];
    }

    /**
     * 获取列表选定value值
     * @param string $html html列表
     * @return string
     */
    public function getSelectedWeekValue(string $html): string
    {
        preg_match('/<option value="(.*?)".*selected="selected">/', $html, $value);
        return $value ? $value[1] : '';
    }

    /**
     * 解析匹配个人课表单元格内课程信息
     * @param string $html 单元格HTML
     * @param string $startAt 上课时间
     * @param string $endAt 下课时间
     * @return array
     */
    public function formatStudentCellHtmlCourse(string $html, string $startAt = '', string $endAt = ''): array
    {
        // 空课程单元格
        if (empty($this->stripHtmlTagAndBlankspace($html))) return [];
        // 匹配课程名
        preg_match_all('/[r" ]>(.*?)老师?/', $html, $courseNames);
        $courseNames = $courseNames ? $courseNames[1] : [];
        // 匹配教师
        preg_match_all('/老师.*?>(.*?)<.*?周次/', $html, $teacherNames);
        $teacherNames = $teacherNames ? $teacherNames[1] : [];
        // 匹配周/节次
        preg_match_all('/周次.*?>(.*?)</', $html, $weekAndSernos);
        $weekAndSernos = $weekAndSernos ? $weekAndSernos[1] : [];
        // 细分 匹配周
        preg_match_all('/周次.*?>(.*?)\(周\)/', $html, $weeks);
        $weeks = $weeks ? $weeks[1] : [];
        // 细分匹配节次
        preg_match_all('/\(周\)\[(.*?)节\]</', $html, $serialNos);
        $serialNos = $serialNos ? $serialNos[1] : [];
        // 匹配教室
        preg_match_all('/教室.*?>(.*?)</', $html, $places);
        $places = $places ? $places[1] : [];

        $courses = [];
        foreach ($courseNames as $index => $courseName) {
            $courseName = $this->stripHtmlTagAndBlankspace($courseName);
            // P备注带括号，否则容易出现 xxx学P，例如：康复护理学P
            $courseName = preg_replace('/P$/', '(P)', $courseName);
            $courseName = preg_replace('/O$/', '(O)', $courseName);
            $item = [
                'courseName' => $courseName,
                'teacher'    => isset($teacherNames[$index]) ? (string)$teacherNames[$index] : '',
                'teachTime'  => isset($weekAndSernos[$index]) ? (string)$weekAndSernos[$index] : '',
                'teachWeek'  => isset($weeks[$index]) ? (string)$weeks[$index] : '',
                'teachNo'    => isset($serialNos[$index]) ? (string)$serialNos[$index] : '',
                'place'      => isset($places[$index]) ? (string)$places[$index] : '',
            ];
            if (!empty($startAt)) $item['startAt'] = $startAt;
            if (!empty($endAt)) $item['endAt'] = $endAt;
            $courses[] = $item;
        }
        return $courses;
    }

    /**
     * 解析匹配教师课表单元格内课程信息
     * @param string $html
     * @param string $startAt
     * @param string $endAt
     * @return array
     */
    public function formatTeacherCellHtmlCourse(string $html, string $startAt = '', string $endAt = ''): array
    {
        // 空课程单元格
        if (empty($this->stripHtmlTagAndBlankspace($html))) return [];
        // 匹配课程名
        preg_match_all('/[r" ]>(.*?)周次?/', $html, $courseNames);
        $courseNames = $courseNames ? $courseNames[1] : [];
        // 匹配周
        preg_match_all('/周次.*?>(.*?)</', $html, $weeks);
        $weeks = $weeks ? $weeks[1] : [];
        // 匹配教室
        preg_match_all('/教室.*?>(.*?)\[/', $html, $places);
        $places = $places ? $places[1] : [];
        // 匹配节次
        preg_match_all('/\[([\d-]*?)]节/', $html, $serialNos);
        $serialNos = $serialNos ? $serialNos[1] : [];
        // 匹配班级
        preg_match_all('/节<\/font><br\/>(.*?):\d*?<br/', $html, $classNames);
        $classNames = $classNames ? $classNames[1] : [];
        // 匹配上课人数
        preg_match_all('/班:(\d*?)<br/', $html, $people);
        $people = $people ? $people[1] : [];
        // 匹配考核方式
        preg_match_all('/:\d*?<br\/>(.*?)<br\/>总学时/', $html, $accessMethod);
        $accessMethod = $accessMethod ? $accessMethod[1] : [];
        // 总学时
        preg_match_all('/>总学时：(\d*?)</', $html, $period);
        $period = $period ? $period[1] : [];

        $courses = [];
        foreach ($courseNames as $index => $courseName) {
            $courseName = $this->stripHtmlTagAndBlankspace($courseName);
            // P备注带括号，否则容易出现 xxx学P，例如：康复护理学P
            $courseName = preg_replace('/P$/', '(P)', $courseName);
            $courseName = preg_replace('/O$/', '(O)', $courseName);
            $item = [
                'courseName' => $courseName,
                'teachWeek'  => isset($weeks[$index]) ? (string)$weeks[$index] : '',
                'teachNo'    => isset($serialNos[$index]) ? (string)$serialNos[$index] : '',
                'place'      => isset($places[$index]) ? (string)$places[$index] : '',
                'className' => isset($classNames[$index]) ? (string)$classNames[$index] : '',
                'people'     => isset($people[$index]) ? (string)$people[$index] : '',
                'accessMethod' => isset($accessMethod[$index]) ? (string)$accessMethod[$index] : '',
                'period'     => isset($period[$index]) ? (string)$period[$index] : '',
            ];
            if (!empty($startAt)) $item['startAt'] = $startAt;
            if (!empty($endAt)) $item['endAt'] = $endAt;
            $courses[] = $item;
        }
        return $courses;
    }

    /**
     * 按星期分类课表
     * @param array $coursesList 6x7列表课表
     * @param array $columnTitles 7值星期标题数组
     * @return array
     */
    public function classifyCourseTableByDayOfWeek(array $coursesList, array $columnTitles): array
    {
        $courses = [];
        foreach ($coursesList as $index => $item) {
            $remainder = $index % 7;
            if (!isset($courses[$remainder]['title'])) $courses[$remainder]['title'] = $columnTitles[$remainder];
            if (!isset($courses[$remainder]['items'])) $courses[$remainder]['items'] = [];
            $courses[$remainder]['items'][] = $item;
        }
        return $courses;
    }

    /**
     * 获取某日的周课表
     * @param string $date Y-m-d日期，默认当天
     * @return array
     * @throws Exception
     */
    public function dateCourse(string $date = ''): array
    {
        if (empty($date)) $date = date('Y-m-d');
        $post = "rq={$date}";
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain_new.jsp?t1=1';
        $html = $this->httpPost('/jsxsd/framework/main_index_loadkb.jsp', $post, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return array_merge(
            $this->formatDateCourse($html['data']),
            ['date' => $date]
        );
    }

    /**
     * @param string $html
     * @return array
     */
    public function formatDateCourse(string $html): array
    {
        // 周次信息
        preg_match('/#li_showWeek"\).html\("(.*?)"\)/', $html, $queryWeek);
        $queryWeek = $queryWeek ? $queryWeek[1] : '';
        // 查询日期所属当前教学周
        preg_match('/>(.*?)</', $queryWeek, $queryNowWeek);
        $queryNowWeek = $queryNowWeek ? $queryNowWeek[1] : '';
        // 查询日期所属学期最后一周
        preg_match('/>\/(.*?)$/', $queryWeek, $queryEndWeek);
        $queryEndWeek = $queryEndWeek ? $queryEndWeek[1] : '';

        // 所有单元格（除标题首行外）
        preg_match_all('/<td.*?>(.*?)<\/td/s', $html, $tdHtmls);
        $tdHtmls = $tdHtmls ? $tdHtmls[1] : [];

        // 课表列表头（仅星期）
        preg_match_all('/<th.*?>(.*?)<\/th/', $html, $columnTitles);
        $columnTitles = $columnTitles ? $columnTitles[1] : [];
        unset($columnTitles[0]);
        $columnTitles = array_values($columnTitles);

        // 课程列表
        $coursesList = [];
        $rowTitles = [];
        $rowIndex = 0;
        foreach ($tdHtmls as $tdIndex => $tdHtml) {
            $remainder = $tdIndex % 8;
            // 节次时间列
            if ($remainder === 0) {
                $rowTitles[] = $this->formatDateCellHtmlRowTitle($tdHtml);
                continue;
            }
            $startAt = $rowTitles[$rowIndex]['startAt'];
            $endAt = $rowTitles[$rowIndex]['endAt'];
            $coursesList[] = $this->formatDateCellHtmlCourse($tdHtml, $startAt, $endAt);
            if ($remainder === 7) $rowIndex++;
        }

        // 按星期分类课表
        $courses = $this->classifyCourseTableByDayOfWeek($coursesList, $columnTitles);

        $tips = $this->stripHtmlTagAndBlankspace($queryWeek);
        if (strpos($html, '当前日期不在教学周历内')) $tips = '所选日期不在教学周历内';

        return [
            'table'       => $courses,
            'columnTitle' => $columnTitles,
            'rowTitle'    => $rowTitles,
            'nowWeek'     => $queryNowWeek,
            'endWeek'     => $queryEndWeek,
            'tips'        => $tips
        ];
    }

    /**
     * 解析匹配格式化日期个人课表行标题信息
     * @param string $html
     * @return array
     */
    public function formatDateCellHtmlRowTitle(string $html): array
    {
        $data = ['title' => '', 'time' => '', 'startAt' => '', 'endAt' => ''];
        $html = $this->stripBlankspace($html);
        $lines = explode('<br/>', $html);
        if (!isset($lines[1])) return $data;
        $times = explode('-', $lines[1]);
        if (!isset($times[1]) || !isset($times[0])) return $data;
        return [
            'title'   => $lines[0],
            'time'    => $lines[1],
            'startAt' => $times[0],
            'endAt'   => $times[1]
        ];
    }

    /**
     * 解析匹配格式化日期个人课表单元格课程信息
     * @param string $html
     * @param string $startAt
     * @param string $endAt
     * @return array
     */
    public function formatDateCellHtmlCourse(string $html, string $startAt = '', string $endAt = ''): array
    {
        $course = [];
        $html = $this->stripBlankspace($html);
        // 空课
        if (empty($html)) return $course;

        preg_match('/课程学分：(.*?)课程属性/', $html, $courseCredit);
        $courseCredit = $courseCredit ? $courseCredit[1] : '';

        preg_match('/课程属性：(.*?)课程名称/', $html, $classType);
        $classType = $classType ? $classType[1] : '';

        preg_match('/课程名称：(.*?)上课时间/', $html, $courseName);
        $courseName = $courseName ? $courseName[1] : '';

        preg_match('/上课时间：(.*?)上课地点/', $html, $teachTime);
        $teachTime = $teachTime ? $teachTime[1] : '';

        preg_match('/上课时间：(.*?)星期/', $html, $teachWeek);
        $teachWeek = $teachWeek ? $teachWeek[1] : '';

        preg_match('/上课时间.*? (.*?) .*?上课地点/', $html, $dayOfWeek);
        $dayOfWeek = $dayOfWeek ? $dayOfWeek[1] : '';

        preg_match('/上课时间.*?\[(.*?)\]节/', $html, $teachNo);
        $teachNo = $teachNo ? $teachNo[1] : '';

        preg_match('/上课地点：(.*?)\'.*?>/', $html, $place);
        $place = $place ? $place[1] : '';

        $course = [
            'courseName' => $courseName,
            'teachTime'  => $teachTime,
            'teachWeek'  => $teachWeek,
            'teachNo'    => $teachNo,
            'place'      => $place,
            'dayOfWeek'  => $dayOfWeek
        ];

        if (!empty($startAt)) $course['startAt'] = $startAt;
        if (!empty($endAt)) $course['endAt'] = $endAt;

        foreach ($course as $key => $value) {
            $course[$key] = $this->stripHtmlTagAndBlankspace($value);
        }

        return $course;
    }

}