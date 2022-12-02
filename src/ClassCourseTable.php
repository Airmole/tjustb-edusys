<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 班级课表查询
 */
class ClassCourseTable extends Base
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
            'semester'  => $semesterOptions,
            'timeModel' => $timeModelOptions,
            'college'   => $collegeOptions,
            'grade'     => $gradeOptions
        ];
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
        $query = "&skyx={$collegeCode}&sknj={$grade}";  // 这里不是错误，教务就是这么写的。。。无语了
        $url = '/jsxsd/kbcx/getZyByAjax?' . $query;
        $referer = $this->edusysUrl . '/jsxsd/kbcx/kbxx_xzb';
        $jsonStr = $this->httpGet($url, $this->cookie, $referer);
        $json = json_decode($jsonStr['data'], true);
        if (is_array($json)) $data = $json;
        return $data;
    }

    /**
     * @param string $semester 学年学期 2022-2023-1
     * @param string $timeModel 时间模式
     * @param string $college 院系
     * @param string $grade 年级（四位年份数字）
     * @param string $profession 专业
     * @param string $className 班级名称
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @return array
     * @throws Exception
     */
    public function classCourse(
        string $semester = '',
        string $timeModel = '',
        string $college = '',
        string $grade = '',
        string $profession = '',
        string $className = '',
        string $weekStart = '',
        string $weekEnd = '',
        string $dayOfWeekStart = '',
        string $dayOfWeekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = ''
    ): array
    {
        $postPara = [
            'xnxqh'    => $semester,
            'kbjcmsid' => $timeModel,
            'skyx'     => $college,
            'sknj'     => $grade,
            'skzy'     => $profession,
            'skbjid'   => '',
            'skbj'     => $className,
            'zc1'      => $weekStart,
            'zc2'      => $weekEnd,
            'skxq1'    => $dayOfWeekStart,
            'skxq2'    => $dayOfWeekEnd,
            'jc1'      => $serialNoStart,
            'jc2'      => $serialNoEnd
        ];
        $post = http_build_query($postPara);
        $referer = $this->edusysUrl . '/jsxsd/kbcx/kbxx_xzb';
        $html = $this->httpPost('/jsxsd/kbcx/kbxx_xzb_ifr', $post, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        $html = $this->stripBlankspace($html['data']);
        return $this->formatClassCourseTables($html);
    }

    /**
     * 匹配解析班级课表
     * @param string $html
     * @return array
     */
    public function formatClassCourseTables(string $html): array
    {
        preg_match_all('/center"><nobr>(.*?)<\/nobr><\/td/', $html, $classNames);
        $classNames = $classNames ? $classNames[1] : [];

        preg_match_all('/top">(.*?)<\/td/', $html, $tdHtmls);
        $tdHtmls = $tdHtmls ? $tdHtmls[1] : [];

        $rows = [];
        $classCourseList = [];
        $classDayCourses = [];
        $rowIndex = 0;
        $weekIndex = 0;
        foreach ($tdHtmls as $tdIndex => $tdHtml) {
            $className = $classNames[$rowIndex];
            $remainder = $tdIndex % 6;
            $startAt = self::START_ATS[$remainder];
            $endAt = self::END_ATS[$remainder];
            $classCourseList[] = $this->formatCellCourse($tdHtml, $className, $startAt, $endAt);
            if (count($classCourseList) === 6) {
                $classDayCourses[$weekIndex]['items'] = $classCourseList;
                $classDayCourses[$weekIndex]['title'] = "星期" . self::WEEKS_ARRAY[$weekIndex];
                $classCourseList = [];
                $weekIndex++;
            }
            if ((42 * ($rowIndex + 1)) - 1 === $tdIndex) {
                $rows[$rowIndex]['className'] = $className;
                $rows[$rowIndex]['course'] = $classDayCourses;
                $classCourseList = [];
                $classDayCourses = [];
                $weekIndex = 0;
                $rowIndex++;
            }
        }

        return $rows;
    }

    /**
     * 匹配解析单元格课表
     * @param string $html
     * @param string $className
     * @param string $startAt
     * @param string $endAt
     * @return array
     */
    public function formatCellCourse(string $html, string $className = '', string $startAt = '', string $endAt = ''): array
    {
        $course = [];
        if (empty($this->stripHtmlTagAndBlankspace($html))) return $course;

        preg_match_all('/kbcontent1\">(.*?)<br>/', $html, $courseNames);
        $courseNames = $courseNames ? $courseNames[1] : [];

        preg_match_all('/<br>(.*?)<br>.*?周/', $html, $classNames);
        $classNames = $classNames ? $classNames[1] : [];

        preg_match_all('/\w<br>(.*?)\(.*?周\)<br/', $html, $teacherNames);
        $teacherNames = $teacherNames ? $teacherNames[1] : [];

        preg_match_all('/<br>.*?\((.*?周)\)<br>/', $html, $weeks);
        $weeks = $weeks ? $weeks[1] : [];

        preg_match_all('/周\)<br>(.*?)<\/div/', $html, $places);
        $places = $places ? $places[1] : [];

        foreach ($courseNames as $index => $courseName) {
            $courseName = $this->stripHtmlTagAndBlankspace(str_replace($className, '', $courseName));
            // P备注带括号，否则容易出现 xxx学P，例如：康复护理学P
            $courseName = preg_replace('/P$/', '(P)', $courseName);
            $courseName = preg_replace('/O$/', '(O)', $courseName);
            $className = $className ? (string)$className : (isset($classNames[$index]) ? (string)$classNames[$index] : '');
            $teacherName = $this->stripHtmlTagAndBlankspace(str_replace($className, '', $teacherNames[$index]));
            $place = isset($places[$index]) ? (string)$places[$index] : '';
            $week = isset($weeks[$index]) ? (string)$weeks[$index] : '';
            $item = [
                'courseName' => $courseName,
                'className'  => $className,
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