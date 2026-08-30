<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 服务类抽象基类
 * 统一处理 cookie 和 usercode 参数校验
 */
abstract class AbstractService extends Base
{
    /**
     * @var string 参数校验失败时的错误消息
     */
    protected string $cookieEmptyMessage = 'cookie不得为空';

    /**
     * @var string 账号参数校验失败时的错误消息
     */
    protected string $usercodeEmptyMessage = '学号参数不得为空';

    /**
     * 初始化
     * @param string $usercode 账号
     * @param string $cookie Cookie
     * @throws Exception
     */
    public function __construct(string $usercode = '', string $cookie = '')
    {
        parent::__construct();
        $this->cookie = $cookie;
        $this->usercode = $usercode;
        if (empty($this->cookie)) throw new Exception($this->cookieEmptyMessage);
        if (empty($this->usercode)) throw new Exception($this->usercodeEmptyMessage);
    }
}
