<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 系统主方法
 */
class Edusys
{
    /**
     * @var string 账号
     */
    public string $usercode;

    /**
     * @var string 可用cookie值（仅登录成功后赋值）
     */
    public string $cookie;

    /**
     * @var string 登录模式： new,old,sso
     */
    public string $mode;

    public function __construct(string $mode = 'new')
    {
        if (empty($this->mode)) $this->mode = $mode;
    }

    /**
     * 获取登录所需参数
     * @return array
     * @throws Exception
     */
    public function getLoginPara(): array
    {
        $login = $this->mode === 'sso' ? new SsoLogin() : new Login($this->mode);
        return $login->getLoginPara();
    }

    /**
     * 手动登录（需获取登录参数，手动输入验证码）
     * @param string $usercode
     * @param string $password
     * @param string $captcha
     * @param string $cookie
     * @param string $salt sso模式必填
     * @param string $execution sso模式必填
     * @return array
     * @throws Exception
     */
    public function selfLogin(string $usercode, string $password, string $captcha, string $cookie, string $salt = '', string $execution = ''): array
    {
        $login = new Login($this->mode);
        $result = $login->login($usercode, $password, $captcha, $cookie, $salt, $execution);
        if ($result['code'] === Base::CODE_SUCCESS) {
            $this->usercode = $usercode;
            $this->cookie = $result['data'];
        }

        return $result;
    }

    /**
     * 自动登录（仅需账号密码）
     * @param string $usercode
     * @param string $password
     * @param int $retry
     * @return array
     * @throws Exception
     */
    public function autoLogin(string $usercode, string $password, int $retry = 1): array
    {
        $login = new Login($this->mode);
        $result = $login->autoLogin($usercode, $password, $retry);
        if ($result['code'] === Base::CODE_SUCCESS) {
            $this->usercode = $usercode;
            $this->cookie = $result['data'];
        }
        return $result;
    }

    /**
     * 注销登录
     * @return array
     * @throws Exception
     */
    public function logout(): array
    {
        if (empty($this->cookie)) throw new Exception('cookie为空,无需注销');
        $login = new Login();
        $result = $login->logout($this->cookie);
        if ($result['code'] === Base::CODE_SUCCESS) $this->cookie = '';
        return $result;
    }

    /**
     * 修改密码
     * @param string $nowPwd 现密码
     * @param string $newPwd 新密码
     * @param string $repeatNewpwd 新密码重复
     * @return array
     * @throws Exception
     */
    public function changePassword(string $nowPwd, string $newPwd, string $repeatNewpwd): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $login = new Login();
        $result = $login->changePassword($this->cookie, $nowPwd, $newPwd, $repeatNewpwd);
        if ($result['code'] !== Base::CODE_SUCCESS) throw new Exception($result['data']);
        return $result;
    }

    /**
     * 获取资料信息
     * @return array
     * @throws Exception
     */
    public function profile(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $profile = new Profile($this->usercode, $this->cookie);
        $profile = $profile->getProfile();
        if ($profile['code'] !== Base::CODE_SUCCESS) throw new Exception('获取失败');
        return $profile['data'];
    }

    /**
     * 获取学籍照片(base64)
     * @return string
     * @throws Exception
     */
    public function photo(): string
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $profile = new Profile($this->usercode, $this->cookie);
        return $profile->photo();
    }

    /**
     * 获取成绩查询筛选选项列表
     * @return array
     * @throws Exception
     */
    public function scoreQueryOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $score = new Score($this->usercode, $this->cookie);
        return $score->scoreQueryOptions();
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
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $score = new Score($this->usercode, $this->cookie);
        return $score->score($time, $nature, $course, $show, $classify);
    }

    /**
     * 个人学期课表
     * @param string $week 上课周
     * @param string $semester 学期
     * @return array
     * @throws Exception
     */
    public function semesterCourseTable(string $week = '', string $semester = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $course = new CourseTable($this->usercode, $this->cookie);
        return $course->semesterCourse($week, $semester);
    }

    /**
     * 个人学期课表筛选项列表
     * @return array
     * @throws Exception
     */
    public function courseTableOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $course = new CourseTable($this->usercode, $this->cookie);
        return $course->myCourseQueryOptions();
    }

    /**
     * 获取某日的周课表
     * @param string $date Y-m-d日期，默认当天
     * @return array
     * @throws Exception
     */
    public function dateCourseTable(string $date = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $course = new CourseTable($this->usercode, $this->cookie);
        return $course->dateCourse($date);
    }

    /**
     * 教学周历筛选项
     * @return array
     * @throws Exception
     */
    public function calendarOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $calendar = new Calendar($this->usercode, $this->cookie);
        return $calendar->calencarOptions();
    }

    /**
     * 获取教学周历
     * @param string $semester
     * @return array
     * @throws Exception
     */
    public function calendar(string $semester = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $calendar = new Calendar($this->usercode, $this->cookie);
        return $calendar->calendar($semester);
    }

    /**
     * 班级课表查询筛选项列表
     * @return array
     * @throws Exception
     */
    public function classCourseOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classCourse = new ClassCourseTable($this->usercode, $this->cookie);
        return $classCourse->options();
    }

    /**
     * 获取专业
     * @param string $collegeCode 院系代码（可从classCourseOptions()方法返回获取）
     * @param string $grade 年级（四位年份数字）
     * @return array
     * @throws Exception
     */
    public function getProfessions(string $collegeCode = '', string $grade = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classCourse = new ClassCourseTable($this->usercode, $this->cookie);
        return $classCourse->getProfessionsByCollege($collegeCode, $grade);
    }

    /**
     * 班级课表查询
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
     * @param int $timeout 请求超时时间（秒）
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
        string $serialNoEnd = '',
        int $timeout = 30
    ): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classCourse = new ClassCourseTable($this->usercode, $this->cookie);
        return $classCourse->classCourse(
            $semester,
            $timeModel,
            $college,
            $grade,
            $profession,
            $className,
            $weekStart,
            $weekEnd,
            $dayOfWeekStart,
            $dayOfWeekEnd,
            $serialNoStart,
            $serialNoEnd,
            $timeout
        );
    }

    /**
     * 教师课表查询筛选项
     * @return array
     * @throws Exception
     */
    public function teacherCourseOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $teacherCourse = new TeacherCourseTable($this->usercode, $this->cookie);
        return $teacherCourse->options();
    }

    /**
     * 教师课表查询
     * @param string $semester 学年学期 2022-2023-1
     * @param string $timeModel 时间模式
     * @param string $college 院系
     * @param string $teacherLevel 教师职称
     * @param string $teacherName 教师姓名
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param int $timeout 请求超时时间（秒）
     * @return array
     * @throws Exception
     */
    public function teacherCourse(
        string $semester = '',
        string $timeModel = '',
        string $college = '',
        string $teacherLevel = '',
        string $teacherName = '',
        string $weekStart = '',
        string $weekEnd = '',
        string $dayOfWeekStart = '',
        string $dayOfWeekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        int $timeout = 30
    ): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $teacherCourse = new TeacherCourseTable($this->usercode, $this->cookie);
        return $teacherCourse->teacherCourse(
            $semester,
            $timeModel,
            $college,
            $teacherLevel,
            $teacherName,
            $weekStart,
            $weekEnd,
            $dayOfWeekStart,
            $dayOfWeekEnd,
            $serialNoStart,
            $serialNoEnd,
            $timeout
        );
    }

    /**
     * 课程课表查询筛选项
     * @return array
     * @throws Exception
     */
    public function lessonCourseOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $lessonCourse = new LessonCourseTable($this->usercode, $this->cookie);
        return $lessonCourse->options();
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
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $lessonCourse = new LessonCourseTable($this->usercode, $this->cookie);
        return $lessonCourse->lessonCourse(
            $semester,
            $timeModel,
            $studyCollege,
            $teachCollege,
            $courseNature,
            $courseName,
            $weekStart,
            $weekEnd,
            $dayOfWeekStart,
            $dayOfWeekEnd,
            $serialNoStart,
            $serialNoEnd,
            $timeout
        );
    }

    /**
     * 教室借用情况筛选项
     * @return array
     * @throws Exception
     */
    public function classroomStatusOptions(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classroom = new Classroom($this->usercode, $this->cookie);
        return $classroom->options();
    }

    /**
     * 教室状态查询及详情所需参数
     * @param string $semester 学年学期
     * @param string $timeModel 时间模式
     * @param string $schoolArea 校区
     * @param string $teachArea 教学区
     * @param string $classroomType 教室类型
     * @param string $teachBuilding 教学楼
     * @param string $classroomCode 教室
     * @param string $peopleSign 容纳人数比较符号
     * @param string $peopleNum 容纳人数
     * @param string $classroomStatus 教室状态
     * @param string $borrowCollege 借用院系
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param string $classroomOwned 教室所属单位
     * @return array[]
     * @throws Exception
     */
    public function classroomStatus(
        string $semester = '',
        string $timeModel = '',
        string $schoolArea = '',
        string $teachArea = '',
        string $classroomType = '',
        string $teachBuilding = '',
        string $classroomCode = '',
        string $peopleSign = '',
        string $peopleNum = '',
        string $classroomStatus = '',
        string $borrowCollege = '',
        string $weekStart = '',
        string $weekEnd = '',
        string $dayOfWeekStart = '',
        string $dayOfWeekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        string $classroomOwned = ''
    ): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classroom = new Classroom($this->usercode, $this->cookie);
        return $classroom->classroom(
            $semester,
            $timeModel,
            $schoolArea,
            $teachArea,
            $classroomType,
            $teachBuilding,
            $classroomCode,
            $peopleSign,
            $peopleNum,
            $classroomStatus,
            $borrowCollege,
            $weekStart,
            $weekEnd,
            $dayOfWeekStart,
            $dayOfWeekEnd,
            $serialNoStart,
            $serialNoEnd,
            $classroomOwned
        );
    }

    /**
     * 教学地点列表（教学区、教学楼、教室）
     * @param string $type 类型：area-教学区，building-教学楼，classroom-教室
     * @param string $buildingId 教学楼ID
     * @return array
     * @throws Exception
     */
    public function classroomList(string $type = 'classroom', string $buildingId = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classroom = new Classroom($this->usercode, $this->cookie);
        return $classroom->classroomList($type, $buildingId);
    }

    /**
     * 获取教室借用详情信息
     * @param string $semester 学年学期
     * @param string $timeModel 时间模式
     * @param string $classroomCode 教室编码
     * @param string $serialValue 节次序号
     * @param string $dayOfWeek 星期几
     * @param string $startAt 开始时间
     * @param string $endAt 结束时间
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param string $classroomStatus 教室状态
     * @return array
     * @throws Exception
     */
    public function classroomDetail(
        string $semester = '',
        string $timeModel = '',
        string $classroomCode = '',
        string $serialValue = '',
        string $dayOfWeek = '',
        string $startAt = '',
        string $endAt = '',
        string $dayOfWeekStart = '1',
        string $dayOfWeekEnd = '7',
        string $weekStart = '',
        string $weekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        string $classroomStatus = ''
    ): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $classroom = new Classroom($this->usercode, $this->cookie);
        return $classroom->classroomDetail(
            $semester,
            $timeModel,
            $classroomCode,
            $serialValue,
            $dayOfWeek,
            $startAt,
            $endAt,
            $dayOfWeekStart,
            $dayOfWeekEnd,
            $weekStart,
            $weekEnd,
            $serialNoStart,
            $serialNoEnd,
            $classroomStatus
        );
    }

    /**
     * 教师查询授课列表
     * @throws Exception
     */
    public function teacherCourseList(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $teacher = new Teacher($this->usercode, $this->cookie);
        return $teacher->courseList();
    }

    /**
     * 教师查询学生花名册
     * @param string $queryCode 查询码
     * @return array
     * @throws Exception
     */
    public function teacherQueryStudentList(string $queryCode): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $teacher = new Teacher($this->usercode, $this->cookie);
        return $teacher->queryStudentList($queryCode);
    }

    /**
     * 获取培养方案
     * @return array
     * @throws Exception
     */
    public function trainingPlan(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $plan = new TrainingPlan($this->usercode, $this->cookie);
        return $plan->trainingPlan();
    }

    /**
     * 获取培养方案查询选项
     * @param string $college 学院
     * @param string $grade 年级
     * @param string $profession 专业
     * @return array
     * @throws Exception
     */
    public function trainingPlanOptions(string $college = '', string $grade = '', string $profession = ''): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $plan = new TrainingPlan($this->usercode, $this->cookie);
        return $plan->options($college, $grade, $profession);
    }

    /**
     * 教师查询专业培养方案
     * @param string $grade 年级
     * @param string $profession 专业
     * @param int $page 页码
     * @return array
     * @throws Exception
     */
    public function professionTrainingPlan(string $grade, string $profession, int $page = 1): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $plan = new TrainingPlan($this->usercode, $this->cookie);
        return $plan->professionTrainingPlan($grade, $profession, $page);
    }

    /**
     * 获取需评教学期批次
     * @return array
     * @throws Exception
     */
    public function needEvaluateSemester(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $evaluate = new EvaluateTeacher($this->usercode, $this->cookie);
        return $evaluate->needEvaluateSemester();
    }

    /**
     * 获取评教课程列表
     * @param string $semesterUrl 评教学期批次页面URL
     * @throws Exception
     */
    public function needEvaluateCourse(string $semesterUrl): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $evaluate = new EvaluateTeacher($this->usercode, $this->cookie);
        return $evaluate->needEvaluateCourse($semesterUrl);
    }

    /**
     * 获取评教课程详情
     * @throws Exception
     */
    public function evaluateCourseDetail(string $courseUrl): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $evaluate = new EvaluateTeacher($this->usercode, $this->cookie);
        return $evaluate->evaluateCourseDetail($courseUrl);
    }

}