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
     * 获取资料信息
     * @return array
     * @throws Exception
     */
    public function profile(): array
    {
        if (empty($this->usercode) || empty($this->cookie)) throw new Exception('账号未登录');
        $profile = new Profile($this->usercode, $this->cookie);
        return $profile->getProfile();
    }

}