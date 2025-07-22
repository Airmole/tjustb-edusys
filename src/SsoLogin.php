<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

class SsoLogin extends Base
{
    /**
     * @var string SSO登录地址
     */
    public string $ssoDomain = 'http://authserver.bkty.top';

    /**
     * 获取登录参数
     * @return array
     * @throws Exception
     */
    public function getLoginPara(): array
    {
        $url = $this->ssoDomain . '/authserver/login?service=' . urlencode($this->edusysUrl. '/jsxsd/sso.jsp');
        $result = $this->httpGet($url, '', '', 5, true);
        $httpCode = $result['code'];
        $response = $result['data'];
        if ($httpCode == 502) throw new Exception('学校系统不稳定，请稍候再试(cookie)');
        if ($httpCode == 0 || $httpCode >= 400) throw new Exception('获取cookie失败' . json_encode($response));
        preg_match('/Set-Cookie: route=(.*?); Path=\//i', $response, $routeId);
        preg_match('/Set-Cookie: JSESSIONID=(.*?); path=\//i', $response, $cookie);
        $jsessionidStr = '';
        $routeIdStr = '';
        $separator = '';
        if (!empty($routeId[1])) $routeIdStr = "route={$routeId[1]}";
        if (!empty($cookie[1]) && !empty($routeId[1])) $separator = '; ';
        if (!empty($cookie[1])) $jsessionidStr = "JSESSIONID={$cookie[1]}";
        $cookieStr = $routeIdStr . $separator . $jsessionidStr;
        if (!empty($cookieStr)) $cookieStr = $cookieStr . '; org.springframework.web.servlet.i18n.CookieLocaleResolver.LOCALE=zh_CN';
        preg_match('/id="pwdEncryptSalt" value="(.*?)"/i', $response, $passwordSalt);
        preg_match('/name="execution" value="(.*?)"\/></i', $response, $execution);

        return [
            'cookie' => $cookieStr,
            '_eventId' => 'submit',
            'cllt' => 'userNameLogin',
            'dllt' => 'generalLogin',
            'lt' => '',
            'salt' => empty($passwordSalt[1]) ? '' : $passwordSalt[1],
            'execution' => empty($execution[1]) ? '' : $execution[1]
        ];
    }

    /**
     * 登录
     * @param string $usercode
     * @param string $password
     * @param string $cookie
     * @param string $salt
     * @param string $execution
     * @return array
     * @throws Exception
     */
    public function login(string $usercode, string $password, string $cookie, string $salt, string $execution): array
    {
        if (empty($salt)) throw new Exception('密码salt值不可为空');
        if (empty($execution)) throw new Exception('execution值不可为空');
        // TODO 后续优化支持自动识别滑动验证码
        // if ($this->checkNeedCaptcha($usercode, $cookie)) throw new Exception('需要识别验证码');

        $url = $this->ssoDomain . '/authserver/login?service=' . urlencode($this->edusysUrl. '/jsxsd/sso.jsp');
        $postData = [
            'username' => $usercode,
            'password' => $this->encryptPassword($password, $salt),
            'captcha' => '',
            '_eventId' => 'submit',
            'cllt' => 'userNameLogin',
            'dllt' => 'generalLogin',
            'lt' => '',
            'execution' => $execution
        ];
        $postString = http_build_query($postData);
        $result = $this->httpPostLogin($url, $postString, $cookie);
        if ($result['code'] !== 200) {
            $validateResult = $this->validateLoginResult($result);
            if ($validateResult !== true) return $validateResult;
        }
        preg_match_all('/Set-Cookie: JSESSIONID=(.*?); Path=\/jsxsd/', $result['data'], $newCookie);
        if (!isset($newCookie[1]) || !isset($newCookie[1][0])) throw new Exception('登录获取cookie失败' . json_encode($newCookie));
        $newCookieValue = $newCookie[1][0];
        $newCookie = "JSESSIONID={$newCookieValue}";
        $url = "/jsxsd/sso.jsp;jsessionid={$newCookieValue}";
        $this->httpGet($url, $newCookie, $this->ssoDomain . '/');
        return ['code' => 200, 'data' => $newCookie];
    }

    /**
     * 根据返回结果验证是否登录成功
     * @param array $response
     * @return array|true
     */
    public function validateLoginResult(array $response)
    {
        if (strpos($response['data'], '该账号非常用账号或用户名密码有误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($response['data'], '您提供的用户名或者密码有误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($response['data'], '登录凭证不可用')) return ['code' => 403, 'data' => '登录凭证不可用'];
        if ($response['code'] == 502) return ['code' => 502, 'data' => '学校系统不稳定，请稍后再试'];
        return  true;
    }

    /**
     * 发送登录请求
     * @param string $url
     * @param string $postString
     * @param string $cookie
     * @return array
     */
    public function httpPostLogin(string $url, string $postString, string $cookie): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: ' . $this->ssoDomain,
            'Pragma: no-cache',
            "Referer: {$url}",
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['code' => (int)$httpCode, 'data' => $response];
    }

    /**
     * 检查是否需要验证码
     * @param string $usercode
     * @param string $cookie
     * @return bool
     * @throws Exception
     */
    public function checkNeedCaptcha(string $usercode, string $cookie): bool
    {
        $url = $this->ssoDomain . "/authserver/checkNeedCaptcha.htl?username={$usercode}&_=" . time() . '000';
        $res = $this->httpGet($url, $cookie);
        $httpCode = $res['code'];
        $response = $res['data'];
        if ($httpCode >= 400) throw new Exception('请求是否需要验证码失败' . json_encode($response));

        $result = json_decode($response, true); // {"isNeed":true}
        return (bool)$result['isNeed'];
    }

    /**
     * 密码加密
     * @param string $data
     * @param string $aesKey
     * @return string
     */
    function encryptPassword(string $data, string $aesKey): string
    {
        if (!$aesKey) return $data;
        $aesKey = trim($aesKey);
        $randomString = $this->randomString(64);
        $iv = $this->randomString(16);
        $encrypted = openssl_encrypt($randomString . $data, 'AES-128-CBC', $aesKey, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted);
    }

    /**
     * 密码解密
     * @param string $data
     * @param string $aesKey
     * @return string
     */
    function decryptPassword(string $data, string $aesKey): string
    {
        $iv = $this->randomString(16);
        $decrypted = openssl_decrypt(base64_decode($data), 'AES-128-CBC', $aesKey, OPENSSL_RAW_DATA, $iv);
        return substr($decrypted, 64);
    }

    /**
     * 生成随机字符串
     * @param int $length
     * @return string
     */
    function randomString(int $length): string
    {
        $characters = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}