<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * Base
 * 公共通用的方法
 */
class Base
{
    /**
     * 状态码 成功
     */
    public const CODE_SUCCESS = 200;

    /**
     * @var string 教务URL域名
     */
    public string $edusysUrl;

    /**
     * @var string 配置文件路径
     */
    public string $configPath;

    /**
     * @var string 账号
     */
    public string $usercode;
    
    /**
     * @var string 可用cookie值（仅登录成功后赋值）
     */
    public string $cookie;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        // 未配置教务URL 自动配置
        if (empty($this->edusysUrl)) $this->setEdusysUrl();
        // 设置默认配置文件
        if (empty($this->configPath)) $this->setConfigPath();
    }

    /**
     * 设置可用教务URL
     * @param array $urls 教务系统URL配置数组
     * @return void
     * @throws Exception 教务系统关闭抛出异常
     */
    public function setEdusysUrl(array $urls = [])
    {
        if (empty($urls)) {
            $urls = ['http://117.131.241.67:89', 'http://61.181.145.1:89', 'http://jiaowu.airmole.cn:808'];
        }

        foreach ($urls as $url) {
            $code = $this->getEdusysStatusCode($url);
            if ($code === 200) {
                $this->edusysUrl = $url;
                return;
            }
        }
        if (empty($this->edusysUrl)) throw new Exception('教务系统未开启？');
    }

    /**
     * 获取系统状态码
     * @param string $url
     * @param int $timeout
     * @return mixed
     */
    public function getEdusysStatusCode(string $url, int $timeout = 5): int
    {
        $url = $url . '/jsxsd/';
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_HEADER         => true,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_NOBODY         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST  => "GET"
        ));
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return (int)$httpCode;
    }

    /**
     * 设置配置文件路径
     * @param string $path
     * @return void
     */
    public function setConfigPath(string $path = '')
    {
        $defaultPath = $_SERVER['DOCUMENT_ROOT'] . '/../.env';
        if ($path === '') $path = $defaultPath;
        $this->configPath = $path;
    }

    /**
     * 强制设置教务URL
     * @param string $url 教务系统URL
     * @return void
     */
    public function setEdusysUrlForce(string $url = 'http://61.181.145.1:89')
    {
        $this->edusysUrl = $url;
    }

    /**
     * GET 请求
     * @param string $url 请求URL
     * @param string $cookie 携带cookie
     * @param string $referer header->referer
     * @param int $timeout 请求超时时间（秒）
     * @param bool $showHeader 返回信息包含Header
     * @return array
     */
    public function httpGet(
        string $url,
        string $cookie = '',
        string $referer = '',
        int    $timeout = 5,
        bool   $showHeader = false
    ): array
    {
        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
            $url = $this->edusysUrl . $url;
        }
        $headers = [
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: zh',
        ];
        if (!empty($referer)) $headers[] = "Referer: {$referer}";
        if (!empty($cookie)) $headers[] = "Cookie: {$cookie}";
        $timeout = $this->getConfig('EDUSYS_TIMEOUT', $timeout);
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => 'gzip, deflate',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_HEADER         => $showHeader,
        ));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['code' => (int)$httpCode, 'data' => $response];
    }

    /**
     * 获取配置项
     * @param string $key
     * @param $default
     * @param string $path
     * @return mixed|null
     */
    public function getConfig(string $key, $default = null, string $path = '')
    {
        $configs = $this->configPath;
        if (!file_exists($configs) && $path === '') return $default;
        preg_match("/{$key}=(.*?)\n/", file_get_contents($configs), $matchedConfig);
        if (empty($matchedConfig) && $path === '') return $default;
        return $matchedConfig[1] ?: $default;
    }

    /**
     * POST 请求
     * @param string $url 请求URL
     * @param string $post post数据
     * @param string $cookie cookie值
     * @param string $referer referer
     * @param int $timeout 请求超时时间(秒)
     * @return array
     */
    public function httpPost(string $url, string $post, string $cookie = '', string $referer = '', int $timeout = 5): array
    {
        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
            $url = $this->edusysUrl . $url;
        }
        preg_match('/^http:\/\/(.*?)\/|^https:\/\/(.*?)\//', $url, $domain);
        $origin = substr($domain[0], 0, -1);

        $headers = [];
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Accept-Language: zh-CN,zh;q=0.9';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Pragma: no-cache';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36';
        $headers[] = "Origin: {$origin}";
        if ($cookie !== '') $headers[] = "Cookie: {$cookie}";
        if ($referer !== '') $headers[] = "Referer: {$referer}";
        $timeout = $this->getConfig('EDUSYS_TIMEOUT', $timeout);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['code' => (int)$httpCode, 'data' => $response];
    }

    /**
     * 清除空格换行以及HTML标签
     * @param string $html
     * @return string
     */
    public function stripHtmlTagAndBlankspace(string $html): string
    {
        $str = trim($html);
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/\t/", "", $str);
        $str = preg_replace("/ /", "", $str);
        $str = trim($str);
        $str = strip_tags($str);
        $str = preg_replace("/&nbsp;/", "", $str);
        return preg_replace("/&nbsp/", "", $str);
    }

    /**
     * 清除换行、空格
     * @param string $html
     * @return string
     */
    public function stripBlankspace(string $html): string
    {
        $str = trim($html);
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/\t/", "", $str);
        $str = trim($str);
        return preg_replace("/&nbsp;/", "", $str);
    }

    /**
     * 根据学号判断是否为教师
     * @param string $uid
     * @return bool
     */
    public function isTeacher(string $uid): bool
    {
        if (strlen($uid) < 8) return true;
        return false;
    }

    /**
     * 根据学号判断是否为学生
     * @param string $uid
     * @return bool
     */
    public function isStudent(string $uid): bool
    {
        if (strlen($uid) < 8) return false;
        return true;
    }

    /**
     * 通过返回的HTML判断cookie值是否可用
     * @param string $html 请求所得HTML内容
     * @return array|bool
     */
    public function checkCookieByHtml(string $html)
    {
        if (strpos($html, '用户名或密码错误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($html, '您的账号在其它地方登录')) return ['code' => 403, 'data' => '您的账号在其它地方登录'];
        if (strpos($html, '请先登录系统')) return ['code' => 403, 'data' => '未登录,请重新登录'];
        return true;
    }

}