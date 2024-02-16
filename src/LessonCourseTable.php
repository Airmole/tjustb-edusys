<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 课程课表查询
 */
class LessonCourseTable extends Base
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
        $html = $this->httpGet('/jsxsd/kbcx/kbxx_kc', $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatOptions($html['data']);
    }

    /**
     * 匹配解析
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
        preg_match('/上课院系.*?开课院系/s', $html, $studyCollegeHtml);
        $studyCollegeHtml = $studyCollegeHtml ? $studyCollegeHtml[0] : '';
        $studyCollegeOptions = $this->formatOption($studyCollegeHtml, '', '/<option value="(.*)?"/');

        // 上课院系
        preg_match('/开课院系.*?课程属性/s', $html, $teachCollegeHtml);
        $teachCollegeHtml = $teachCollegeHtml ? $teachCollegeHtml[0] : '';
        $teachCollegeOptions = $this->formatOption($teachCollegeHtml, '', '/<option value="(.*)?"/');

        // 上课院系
        preg_match('/课程属性.*?课程名称/s', $html, $courseNatureHtml);
        $courseNatureHtml = $courseNatureHtml ? $courseNatureHtml[0] : '';
        $courseNatureOptions = $this->formatOption($courseNatureHtml, '', '/<option value="(.*)?"/');

        return [
            'semester'     => $semesterOptions,
            'timeModel'    => $timeModelOptions,
            'studyCollege' => $studyCollegeOptions,
            'teachCollege' => $teachCollegeOptions,
            'courseNature' => $courseNatureOptions
        ];
    }

    /**
     * 查询课程课表
     * @param string $semester 学年学期
     * @param string $timeModel 时间模式
     * @param string $studyCollege 上课院系
     * @param string $teachCollege 开课院系
     * @param string $courseNature 课程属性
     * @param string $courseName 课程名称
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param int $timeout
     * @return array
     * @throws Exception
     */
    public function lessonCourse(
        string $semester = '',
        string $timeModel = '',
        string $studyCollege = '',
        string $teachCollege = '',
        string $courseNature = '',
        string $courseName = '',
        string $weekStart = '',
        string $weekEnd = '',
        string $dayOfWeekStart = '',
        string $dayOfWeekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        int $timeout = 30
    ): array
    {
        $postPara = [
            'xnxqh'    => $semester,
            'kbjcmsid' => $timeModel,
            'skyx'     => $studyCollege,
            'kkyx'     => $teachCollege,
            'zzdKcSX'  => $courseNature,
            'kcid'     => '',
            'kcmc'     => $courseName,
            'zc1'      => $weekStart,
            'zc2'      => $weekEnd,
            'skxq1'    => $dayOfWeekStart,
            'skxq2'    => $dayOfWeekEnd,
            'jc1'      => $serialNoStart,
            'jc2'      => $serialNoEnd
        ];
        $post = http_build_query($postPara);
        $referer = $this->edusysUrl . '/jsxsd/kbcx/kbxx_kc';
        $html = $this->httpPost('/jsxsd/kbcx/kbxx_kc_ifr', $post, $this->cookie, $referer, $timeout);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        $html = $this->stripBlankspace($html['data']);
        return $this->formatLessonCourseTables($html);
    }

    /**
     * 匹配解析课程课表
     * @param string $html
     * @return array
     */
    public function formatLessonCourseTables(string $html)
    {
        preg_match_all('/center"><nobr>(.*?)<\/nobr><\/td/', $html, $lessonNames);
        $lessonNames = $lessonNames ? $lessonNames[1] : [];

        preg_match_all('/top">(.*?)<\/td/', $html, $tdHtmls);
        $tdHtmls = $tdHtmls ? $tdHtmls[1] : [];

        $rows = [];
        $lessonCourseList = [];
        $classDayCourses = [];
        $rowIndex = 0;
        $weekIndex = 0;
        foreach ($tdHtmls as $tdIndex => $tdHtml) {
            $lessonName = $lessonNames[$rowIndex];
            $remainder = $tdIndex % 6;
            $startAt = self::START_ATS[$remainder];
            $endAt = self::END_ATS[$remainder];
            $lessonCourseList[] = $this->formatCellCourse($tdHtml, $lessonName, $startAt, $endAt);
            if (count($lessonCourseList) === 6) {
                $classDayCourses[$weekIndex]['items'] = $lessonCourseList;
                $classDayCourses[$weekIndex]['title'] = "星期" . self::WEEKS_ARRAY[$weekIndex];
                $lessonCourseList = [];
                $weekIndex++;
            }
            if ((42 * ($rowIndex + 1)) - 1 === $tdIndex) {
                $rows[$rowIndex]['courseName'] = $lessonName;
                $rows[$rowIndex]['course'] = $classDayCourses;
                $lessonCourseList = [];
                $classDayCourses = [];
                $weekIndex = 0;
                $rowIndex++;
            }
        }

        return $rows;
    }

    /**
     * 匹配解析单元格课程
     * @param string $html
     * @param string $lessonName
     * @param string $startAt
     * @param string $endAt
     * @return array
     */
    public function formatCellCourse(string $html, string $lessonName = '', string $startAt = '', string $endAt = ''): array
    {
        $course = [];
        if (empty($this->stripHtmlTagAndBlankspace($html))) return $course;

        preg_match_all('/kbcontent1\">(.*?)<br>/', $html, $courseNames);
        $courseNames = $courseNames ? $courseNames[1] : [];

        preg_match_all('/班<br>(.*?)\(.*?周\)<br/', $html, $teacherNames);
        $teacherNames = $teacherNames ? $teacherNames[1] : [];

        preg_match_all('/<br>.*?\((.*?周)\)<br>/', $html, $weeks);
        $weeks = $weeks ? $weeks[1] : [];

        preg_match_all('/周\)<br>(.*?)<\/div/', $html, $places);
        $places = $places ? $places[1] : [];

        foreach ($courseNames as $index => $courseName) {
            $courseName = $this->stripHtmlTagAndBlankspace($courseName);
            // P备注带括号，否则容易出现 xxx学P，例如：康复护理学P
            $courseName = preg_replace('/P$/', '(P)', $courseName);
            $courseName = preg_replace('/O$/', '(O)', $courseName);
            $teacherName = isset($teacherNames[$index]) ? $this->stripHtmlTagAndBlankspace((string)$teacherNames[$index]) : '';
            $place = isset($places[$index]) ? (string)$places[$index] : '';
            $week = isset($weeks[$index]) ? (string)$weeks[$index] : '';
            $item = [
                'courseName' => $courseName,
                'teacher'    => $teacherName,
                'teachWeek'  => $week,
                'place'      => $place
            ];
            if (!empty($startAt)) $item['startAt'] = $startAt;
            if (!empty($endAt)) $item['endAt'] = $endAt;
            $course[$index] = $item;
        }

        return $course;
    }

}