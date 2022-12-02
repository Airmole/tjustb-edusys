# tjustb-edusys

北京科技大学天津学院教务系统客户端（http://61.181.145.1:89/jsxsd/）

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
$edusys = new Edusys();
// 自动登录
$edusys->autoLogin($usercode, $password); // 自动识别验证码登录，需要在项目根目录下.env文件配置EDUSYS_OCR_URL
// 手动登录
// $loginPara = $edusys->getLoginPara(); // 获取登录所需参数：cookie，captcha
// $captchaText为验证码识别结果值
// $edusys->selfLogin($usercode, $password, $captchaText, $loginPara['cookie']); 
$profile = $edusys->score(); // 查询成绩
// 注销登录系统，建议每次获取完所需数据后注销登录，以免多处登录出现获取失败问题。
$edusys->logout();
print_r($profile);
```

# API

## Edusys

主要常用方法从原类中引入集合到Edusys.php中，使用方式如上所示👆🏻

包含方法如下，完整详细方法、参数、数据结构类型可能与实际修改更新后不一致，若有变动请以源码为准，欢迎提issue.

- [获取登录所需参数](docs/api.md#%E8%8E%B7%E5%8F%96%E7%99%BB%E5%BD%95%E6%89%80%E9%9C%80%E5%8F%82%E6%95%B0)
- [手动登录](docs/api.md#%E6%89%8B%E5%8A%A8%E7%99%BB%E5%BD%95)
- [自动登录](docs/api.md#%E8%87%AA%E5%8A%A8%E7%99%BB%E5%BD%95)
- [注销登录](docs/api.md#%E6%B3%A8%E9%94%80%E7%99%BB%E5%BD%95)
- [修改密码](docs/api.md#%E4%BF%AE%E6%94%B9%E5%AF%86%E7%A0%81)
- [获取资料信息](docs/api.md#%E8%8E%B7%E5%8F%96%E8%B5%84%E6%96%99%E4%BF%A1%E6%81%AF)
- [获取照片](docs/api.md#%E8%8E%B7%E5%8F%96%E7%85%A7%E7%89%87)
- [获取成绩查询选项](docs/api.md#%E8%8E%B7%E5%8F%96%E6%88%90%E7%BB%A9%E6%9F%A5%E8%AF%A2%E9%80%89%E9%A1%B9)
- [获取成绩](docs/api.md#%E6%9F%A5%E8%AF%A2%E6%88%90%E7%BB%A9)
- [获取个人学期课表](docs/api.md#%E8%8E%B7%E5%8F%96%E4%B8%AA%E4%BA%BA%E5%AD%A6%E6%9C%9F%E8%AF%BE%E8%A1%A8)
- [个人学期课表查询选项](docs/api.md#%E4%B8%AA%E4%BA%BA%E5%AD%A6%E6%9C%9F%E8%AF%BE%E8%A1%A8%E7%AD%9B%E9%80%89%E9%A1%B9%E5%88%97%E8%A1%A8)
- [获取某日周课表](docs/api.md#%E8%8E%B7%E5%8F%96%E6%9F%90%E6%97%A5%E7%9A%84%E5%91%A8%E8%AF%BE%E8%A1%A8)
- [教学周历筛选项](docs/api.md#%E6%95%99%E5%AD%A6%E5%91%A8%E5%8E%86%E7%AD%9B%E9%80%89%E9%A1%B9)
- [获取教学周历](docs/api.md#%E8%8E%B7%E5%8F%96%E6%95%99%E5%AD%A6%E5%91%A8%E5%8E%86)
- [班级课表筛选项列表](docs/api.md#%E7%8F%AD%E7%BA%A7%E8%AF%BE%E8%A1%A8%E6%9F%A5%E8%AF%A2%E7%AD%9B%E9%80%89%E9%A1%B9%E5%88%97%E8%A1%A8)
- [获取专业列表](docs/api.md#%E8%8E%B7%E5%8F%96%E4%B8%93%E4%B8%9A%E5%88%97%E8%A1%A8)
- [查询班级课表](docs/api.md#查询班级课表)
- [教师课表查询筛选项列表](docs/api.md#%E6%95%99%E5%B8%88%E8%AF%BE%E8%A1%A8%E6%9F%A5%E8%AF%A2%E7%AD%9B%E9%80%89%E9%A1%B9%E5%88%97%E8%A1%A8)
- [查询教师课表](docs/api.md#%E6%9F%A5%E8%AF%A2%E6%95%99%E5%B8%88%E8%AF%BE%E8%A1%A8)
- [课程课表查询筛选项列表](docs/api.md#%E8%AF%BE%E7%A8%8B%E5%88%97%E8%A1%A8%E7%AD%9B%E9%80%89%E8%AF%A6%E5%88%97%E8%A1%A8)
- [查询课程课表](docs/api.md#%E6%9F%A5%E8%AF%A2%E8%AF%BE%E7%A8%8B%E8%AF%BE%E8%A1%A8)

## 适用学校系统

以本校2017强智教务为目标抓包分析开发而来，其余院校无法测试可用性未测试。各功能代码略有不同，如果您有类似需求，可[联系我](mailto:admin@airmole.cn)有偿开发专用特供版本。
