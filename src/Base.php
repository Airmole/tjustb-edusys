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
     * 星期几
     */
    public const WEEKS_ARRAY = ['一', '二', '三', '四', '五', '六', '日'];

    /**
     * 开始上课时间
     */
    public const START_ATS = ['08:00', '09:55', '13:10', '15:00', '16:50', '19:10'];

    /**
     * 下课时间
     */
    public const END_ATS = ['09:35', '11:30', '14:45', '16:35', '18:25', '21:35'];

    /**
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
     * @param string $url
     * @return void
     */
    public function setEdusysUrl(string $url = 'http://jw.bkty.top:89')
    {
        if (empty($url)) $url = 'http://jw.bkty.top:89';
        $this->edusysUrl = $url;
    }

    /**
     * 获取系统状态码
     * @param string $url
     * @param int $timeout
     * @return mixed
     */
    public function getEdusysStatusCode(string $url, int $timeout = 5): int
    {
        $url = $url . '/';
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
    public function setEdusysUrlForce(string $url = 'http://jw.bkty.top:89')
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
        if (strpos($html, '该帐号不存在或密码错误')) return ['code' => 403, 'data' => '用户名或密码错误'];
        if (strpos($html, '您的账号在其它地方登录')) return ['code' => 403, 'data' => '您的账号在其它地方登录'];
        if (strpos($html, '请先登录系统')) return ['code' => 403, 'data' => '未登录,请重新登录'];
        if (strpos($html, 'authserver.bkty.top/authserver/login')) return ['code' => 403, 'data' => '未登录,请重新登录'];
        return true;
    }

    /**
     * 匹配解析某下拉列表值
     * @param string $html
     * @param string $namePattern
     * @param string $valuePattern
     * @param string $checkedPattern
     * @return array
     * @throws Exception
     */
    public function formatOption(string $html, string $namePattern = '', string $valuePattern = '', string $checkedPattern = '0'): array
    {
        $result = [];
        $namePattern = $namePattern === '' ? '/>(.*)?<\/option>/' : $namePattern;
        $valuePattern = $valuePattern === '' ? '/<option value="(.*)?" /' : $valuePattern;
        $checkedPattern = $checkedPattern === '' ? '/value=(.*?)>/' : $checkedPattern;
        preg_match_all($namePattern, $html, $names);
        preg_match_all($valuePattern, $html, $values);
        if ($checkedPattern !== '0') preg_match_all($checkedPattern, $html, $checkeds);
        $names = $names ? $names[1] : [];
        $values = $values ? $values[1] : [];
        $checkeds = isset($checkeds) && $checkeds ? $checkeds[1] : [];
        if (count($names) !== count($values)) throw new Exception('匹配模式选项列表异常');
        foreach ($names as $index => $name) {
            if ($checkedPattern === '0') {
                $checked = $index === 0;
            } else {
                $checked = strpos($checkeds[$index], 'selected') !== false;
            }
            $result[] = ['name' => $name, 'value' => $values[$index], 'checked' => $checked];
        }
        return $result;
    }

}