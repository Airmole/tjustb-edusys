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
     * @var string 登录模式： new,old
     */
    public string $mode;

    /**
     * 初始化
     * @throws Exception
     */
    public function __construct(string $mode = 'new')
    {
        try {
            parent::__construct();
            $this->mode = $mode;
            // 验证码识别服务引入
            if (empty($this->captchaOcr)) $this->setCaptchaOcr();
        } catch (\Exception $e) {
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
            if ($response['code'] == 403 && strpos($response['data'], '验证码') !== false) {
                continue;
            }
            throw new Exception($response['data']);
        }
        throw new Exception('验证码识别多次失败，建议手动登录');
    }

    /**
     * 获取登录所需参数
     * @return array
     * @throws Exception
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
     * @throws Exception
     */
    public function getCookie(): string
    {
        $url = $this->mode == 'old' ? '/jsxsd/' : '/';
        $html = $this->httpGet($url, '', '', 5, true);
        if ($html['code'] == 0 || $html['code'] >= 400) return '';
        $response = $html['data'];
        preg_match('/Set-Cookie: JSESSIONID=(.*); Path=\//i', $response, $cookie);
        preg_match('/Set-Cookie: SERVERID=(.*); path=\//i', $response, $serverid);
        $jsessionidStr = '';
        $serveridStr = '';
        $separator = '';
        if (!empty($cookie[1])) $jsessionidStr = "JSESSIONID={$cookie[1]}";
        if (!empty($cookie[1]) && !empty($serverid[1])) $separator = '; ';
        if (!empty($serverid[1])) $serveridStr = "SERVERID={$serverid[1]}";
        $cookieStr = $jsessionidStr . $separator . $serveridStr;

        if (empty($cookieStr)) throw new Exception('获取cookie失败');
        return $cookieStr;
    }

    /**
     * 获取验证码（Base64返回）
     * @param string $cookie
     * @return string
     * @throws Exception
     */
    public function getCaptcha(string $cookie): string
    {
        $url = $this->mode == 'old' ? '/jsxsd/verifycode.servlet' : '/verifycode.servlet';
        $referer = $this->edusysUrl . ($this->mode == 'old' ? '/jsxsd/' : '/');
        $response = $this->httpGet($url, $cookie, $referer);

        if ($response['code'] == 0 || $response['code'] >= 400) throw new Exception('获取验证码失败');
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
     * @throws Exception
     */
    public function login(string $usercode, string $password, string $captcha, string $cookie): array
    {
        if ($this->mode == 'new') {
            $logonSess = $this->httpPost($this->edusysUrl . '/Logon.do?method=logon&flag=sess', '', $cookie);
            if ($logonSess['code'] != 200) throw new Exception('获取登录秘钥失败');
            $encoded = $this->signLoginFormValue($logonSess['data'], $usercode, $password);
            $captcha = trim($captcha);
            $post = "userAccount=&userPassword=&RANDOMCODE={$captcha}&encoded={$encoded}";

            $response = $this->httpLoginPost($this->edusysUrl, $cookie, $post);
            $validateResult = $this->validateLoginResult($response);
            if ($validateResult !== true) return $validateResult;

            if ($response['code'] != 302) throw new Exception('login系统异常,请联系开发者');
            $redirectResponse = $this->httpGetFollowLocation($this->edusysUrl, $this->loginedLocationUrl($response['data']), $cookie);
            $url = $this->isStudent($usercode) ? '/jsxsd/framework/xsMain.jsp' : '/jsxsd/framework/jsMain.jsp';
            $mainBoard = $this->httpGet($url, $redirectResponse['cookie'], $this->edusysUrl. '/');
        } else {
            $postString = "userAccount={$usercode}&userPassword=&RANDOMCODE={$captcha}&encoded=";
            $postString = $postString . base64_encode($usercode) . "%25%25%25" . base64_encode($password);
            $referer = $this->edusysUrl . '/jsxsd/';
            $response = $this->httpPost('/jsxsd/xk/LoginToXk', $postString, $cookie, $referer);
            $validateResult = $this->validateLoginResult($response);
            if ($validateResult !== true) return $validateResult;
            if ($response['code'] != 302) throw new Exception('login系统异常,请联系开发者');
            $url = $this->isStudent($usercode) ? '/jsxsd/framework/xsMain.jsp' : '/jsxsd/framework/jsMain.jsp';
            $mainBoard = $this->httpGet($url, $cookie, $this->edusysUrl. '/jsxsd/');
        }

        if ($mainBoard['code'] != 200) throw new Exception('访问主界面异常失败');
        $cookie = $this->mode == 'old' ? $cookie : $redirectResponse['cookie'];
        $this->cookie = $this->mode == 'old' ? $cookie : $redirectResponse['cookie'];
        $this->usercode = $usercode;
        return ['code' => 200, 'data' => $cookie];
    }

    /**
     * 根据返回结果验证是否登录成功
     * @param array $response
     * @return array|true
     */
    public function validateLoginResult(array $response)
    {
        if (strpos($response['data'], '验证码错误')) return ['code' => 403, 'data' => '验证码错误'];
        if (strpos($response['data'], '验证码不能为空')) return ['code' => 403, 'data' => '验证码不能为空'];
        if (strpos($response['data'], '用户名或密码错误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($response['data'], '该帐号不存在或密码错误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($response['data'], '该帐号已锁定')) return ['code' => 403, 'data' => '错误次数过多账号锁定，请半小时后再试'];
        return  true;
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

    /**
     * 计算登录表单提交签名值
     * @param string $sess
     * @param string $usercode
     * @param string $password
     * @return void
     */
    public function signLoginFormValue(string $sess, string $usercode, string $password): string {
        list($scode, $sxh) = explode("#", $sess);
        $code = $usercode . "%%%" . $password;
        $encoded = "";

        for ($i = 0; $i < strlen($code); $i++) {
            if ($i < 20) {
                $encoded .= substr($code, $i, 1) . substr($scode, 0, intval(substr($sxh, $i, 1)));
                $scode = substr($scode, intval(substr($sxh, $i, 1)), strlen($scode));
            } else {
                $encoded .= substr($code, $i, strlen($code));
                $i = strlen($code);
            }
        }

        return urlencode($encoded);
    }

    /**
     * 登录成功重定向链接
     * @param string $response
     * @return string
     */
    public function loginedLocationUrl(string $response) : string {
        preg_match('/Location: (.*)?/', $response, $resultUrl);
        return $this->stripBlankspace($resultUrl[1]);
    }

    /**
     * 新post请求登录方法
     * @param string $domain
     * @param string $cookie
     * @param string $post
     * @return array
     */
    public function httpLoginPost(string $domain, string $cookie, string $post): array
    {
        $url = $domain . '/Logon.do?method=logon';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Accept-Language: zh-CN,zh;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Type: application/x-www-form-urlencoded',
            "Origin: {$domain}",
            'Pragma: no-cache',
            "Referer: {$domain}/",
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36 Edg/119.0.0.0',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['code' => $httpCode, 'data' => $response];
    }

    /**
     * 登录成功专用重定向方法
     * @param string $referer
     * @param string $url
     * @param string $cookie
     * @return array
     */
    public function httpGetFollowLocation(string $referer, string $url, string $cookie): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Accept-Language: zh-CN,zh;q=0.9',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
                'Pragma: no-cache',
                "Referer: {$referer}/",
                "Cookie: {$cookie}",
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36 Edg/119.0.0.0',
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);

        preg_match('/Set-Cookie: JSESSIONID=(.*); Path=\/jsxsd;/i', $response, $newCookie);
        $newCookie = !empty($newCookie[1]) ? $newCookie[1] : '';

        return ['code' => $httpCode, 'data' => $response, 'cookie' => "JSESSIONID={$newCookie}; {$cookie}"];
    }

}