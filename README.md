# tjustb-edusys

北京科技大学天津学院教务系统客户端（http://jw.bkty.top:89）

# Requirement

- PHP >= 7.4

# Installation

```shell
composer require "airmole/tjustb-edusys"
```

# Usage

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys('sso'); // old,new,sso三种登录模式
// 自动登录
$edusys->autoLogin($usercode, $password); // 自动识别验证码登录，需要在项目根目录下.env文件配置EDUSYS_OCR_URL
// 手动登录
// $loginPara = $edusys->getLoginPara(); // 获取登录所需参数：cookie，captcha
// $captchaText为验证码识别结果值
// $edusys->selfLogin($usercode, $password, $captchaText, $loginPara['cookie']); 
$score = $edusys->score(); // 查询成绩
// 注销登录系统，建议每次获取完所需数据后注销登录，以免多处登录出现获取失败问题。
$edusys->logout();
print_r($score);
```

# API

## Edusys

主要常用方法从原类中引入集合到Edusys.php中，使用方式如上所示👆🏻

包含方法见[docs/api.md 文档](docs/api.md)，完整详细方法、参数、数据结构类型可能与实际修改更新后不一致，若有变动请以源码为准，欢迎提issue.


## 适用学校系统

以本校2017强智教务为目标抓包分析开发而来，其余院校无法测试可用性未测试。各功能代码略有不同，如果您有类似需求，可[联系我](mailto:admin@airmole.cn)有偿开发专用特供版本。
