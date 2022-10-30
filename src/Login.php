<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 登录相关
 */
class Login extends Base
{
    /**
     * @var string 验证码识别服务
     */
    public string $captchaOcr;

    /**
     * 初始化
     * @throws Exception
     */
    public function __construct()
    {
        try {
            parent::__construct();
            // 验证码识别服务引入
            if (empty($this->captchaOcr)) $this->setCaptchaOcr();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 设置验证码识别服务URL
     * @param string $url
     * @param string $path
     * @return void
     */
    public function setCaptchaOcr(string $url = '', string $path = '')
    {
        $this->captchaOcr = $this->getConfig('EDUSYS_OCR_URL', $url, $path);
        if (!empty($url)) $this->captchaOcr = $url;
    }

    /**
     * 自动登录（仅需账号密码参数，但务必配置验证码识别服务）
     * @param string $usercode 账号
     * @param string $password 密码
     * @param int $retry 自动重试次数
     * @return array
     * @throws Exception
     */
    public function autoLogin(string $usercode, string $password, int $retry = 1): array
    {
        if (empty($this->captchaOcr)) throw new Exception('未配置验证码识别服务，请使用login方法手动输入验证码登录');
        for ($i = 0; $i < $retry; $i++) {
            $loginPara = $this->getLoginPara();
            $captcha = $this->captchaOcr($loginPara['captcha']);
            $response = $this->login($usercode, $password, $captcha, $loginPara['cookie']);
            if ($response['code'] === 200) return $response;
        }
        throw new Exception('验证码识别多次失败，建议手动登录');
    }

    /**
     * 获取登录所需参数
     * @return array
     */
    public function getLoginPara(): array
    {
        $cookie = $this->getCookie();
        $captcha = $this->getCaptcha($cookie);
        return ['cookie' => $cookie, 'captcha' => $captcha];
    }

    /**
     * 获取教务cookie值
     * @return string
     */
    public function getCookie(): string
    {
        $html = $this->httpGet('/jsxsd/', '', '', 5, true);
        if ($html['code'] == 0 || $html['code'] >= 400) return '';
        $response = $html['data'];
        preg_match('/Set-Cookie: JSESSIONID=(.*); Path=\/jsxsd;/i', $response, $cookie);
        preg_match('/Set-Cookie: SERVERID=(.*); path=\//i', $response, $serverid);
        $jsessionidStr = '';
        $serveridStr = '';
        $separator = '';
        if (!empty($cookie[1])) $jsessionidStr = "JSESSIONID={$cookie[1]}";
        if (!empty($cookie[1]) && !empty($serverid[1])) $separator = '; ';
        if (!empty($serverid[1])) $serveridStr = "SERVERID={$serverid[1]}";
        $cookieStr = $jsessionidStr . $separator . $serveridStr;
        if (!empty($cookieStr)) return $cookieStr;
        return '';
    }

    /**
     * 获取验证码（Base64返回）
     * @param string $cookie
     * @return string
     */
    public function getCaptcha(string $cookie): string
    {
        $referer = $this->edusysUrl . '/jsxsd/';
        $response = $this->httpGet('/jsxsd/verifycode.servlet', $cookie, $referer);
        if ($response['code'] == 0 || $response['code'] >= 400) return '';
        return base64_encode($response['data']);
    }

    /**
     * 验证码识别
     * @param string $captcha
     * @return string
     */
    public function captchaOcr(string $captcha): string
    {
        $response = $this->httpPost($this->captchaOcr, $captcha);
        if ($response['code'] == 0 || $response['code'] >= 400) return '';
        return $response['data'];
    }

    /**
     * 登录
     * @param string $usercode 账号
     * @param string $password 密码
     * @param string $captcha 验证码
     * @param string $cookie cookie
     * @return array
     */
    public function login(string $usercode, string $password, string $captcha, string $cookie): array
    {
        $usercode = base64_encode(trim($usercode));
        $password = base64_encode(trim($password));
        $captcha = trim($captcha);
        $referer = $this->edusysUrl . '/jsxsd/';
        $url = $this->edusysUrl . '/jsxsd/xk/LoginToXk';
        $post = "userAccount=&userPassword=&RANDOMCODE={$captcha}&encoded={$usercode}%25%25%25{$password}";
        $response = $this->httpPost($url, $post, $cookie, $referer);
        if ($response['code'] == 0 || $response['code'] >= 400) return ['code' => (int)$response['code'], 'data' => '系统异常,稍后再试'];
        if (strpos($response['data'], '验证码错误')) return ['code' => 403, 'data' => '验证码错误'];
        if (strpos($response['data'], '验证码不能为空')) return ['code' => 403, 'data' => '验证码不能为空'];
        if (strpos($response['data'], '用户名或密码错误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        $this->cookie = $cookie;
        $this->usercode = $usercode;
        return ['code' => 200, 'data' => $cookie];
    }

    /**
     * 注销登录
     * @param string $cookie cookie值
     * @return array
     */
    public function logout(string $cookie): array
    {
        $url = '/jsxsd/xk/LoginToXk?method=exit&tktime=' . time() . '000';
        $referer = $this->edusysUrl . '/jsxsd/framework/xsMain.jsp';
        $this->cookie = '';
        $this->usercode = '';
        return $this->httpGet($url, $cookie, $referer);
    }

    /**
     * 修改密码
     * @param string $cookie
     * @param string $nowPwd
     * @param string $newPwd
     * @param string $repeatNewpwd
     * @return array
     * @throws Exception
     */
    public function changePassword(string $cookie, string $nowPwd, string $newPwd, string $repeatNewpwd): array
    {
        $nowPwd = trim($nowPwd);
        $newPwd = trim($newPwd);
        $repeatNewpwd = trim($repeatNewpwd);
        if ($newPwd !== $repeatNewpwd) throw new Exception('重复密码不一致');
        if ($nowPwd === $newPwd) throw new Exception('新旧密码不得相同');
        if (strlen($newPwd) < 8 || strlen($repeatNewpwd) < 8) throw new Exception('新秘密不得少于8位');
        preg_match('/^(?=.*\d)(?=.*[a-z])[a-zA-Z0-9]{8,32}$/', $newPwd, $match);
        if (empty($match)) throw new Exception('8位以上且同时包含字母数字');
        $url = $this->edusysUrl . '/jsxsd/grsz/grsz_xgmm';
        $post = "id=&oldpassword={$nowPwd}&password1={$newPwd}&password2={$repeatNewpwd}&upt=1";
        return $this->httpPost($url, $post, $cookie);
    }

}