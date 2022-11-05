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
     * 获取登录所需参数
     * @return array
     */
    public function getLoginPara(): array
    {
        $login = new Login();
        return $login->getLoginPara();
    }

    /**
     * 手动登录（需获取登录参数，手动输入验证码）
     * @param string $usercode
     * @param string $password
     * @param string $captcha
     * @param string $cookie
     * @return array
     */
    public function selfLogin(string $usercode, string $password, string $captcha, string $cookie): array
    {
        $login = new Login();
        $result = $login->login($usercode, $password, $captcha, $cookie);
        if ($result['code'] === Base::CODE_SUCCESS) {
            $this->usercode = $usercode;
            $this->cookie = $cookie;
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
        $login = new Login();
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

}