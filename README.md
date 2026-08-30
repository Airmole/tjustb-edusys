# tjustb-edusys

北京科技大学天津学院教务系统客户端（https://jw.tjustb.cn）

## Requirement

- PHP >= 7.4
- ext-curl, ext-json, ext-openssl

## Installation

```shell
composer require "airmole/tjustb-edusys"
```

## Usage

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys('sso'); // old,new,sso三种登录模式

// 自动登录
$edusys->autoLogin($usercode, $password); // 自动识别验证码登录，需在.env配置EDUSYS_OCR_URL

// 手动登录
// $loginPara = $edusys->getLoginPara(); // 获取登录所需参数：cookie，captcha
// $captchaText为验证码识别结果值
// $edusys->selfLogin($usercode, $password, $captchaText, $loginPara['cookie']);

$score = $edusys->score(); // 查询成绩

// 注销登录系统，建议每次获取完所需数据后注销登录，以免多处登录出现获取失败问题。
$edusys->logout();
print_r($score);
```

## API

### Edusys

主要常用方法从原类中引入集合到 Edusys.php 中，使用方式如上所示。

包含方法见 [docs/api.md 文档](docs/api.md)，完整详细方法、参数、数据结构类型可能与实际修改更新后不一致，若有变动请以源码为准，欢迎提 issue。

## Project Structure

```
src/
├── Base.php              # 基础类：HTTP请求、配置、通用工具方法
├── AbstractService.php   # 服务类抽象基类：统一参数校验
├── Edusys.php            # 门面类：聚合所有功能的入口
├── Login.php             # 教务系统登录（new/old模式）
├── SsoLogin.php          # SSO统一认证登录
├── Profile.php           # 个人资料/学籍信息
├── Score.php             # 成绩查询
├── CourseTable.php       # 个人课表
├── ClassCourseTable.php  # 班级课表
├── TeacherCourseTable.php # 教师课表
├── LessonCourseTable.php # 课程课表
├── Classroom.php         # 教室借用查询
├── Calendar.php          # 教学周历
├── Teacher.php           # 教师账号功能
├── TrainingPlan.php      # 培养方案
├── EvaluateTeacher.php   # 学生评教
└── Exception/
    └── Exception.php     # 自定义异常类
```

## Env Config

读取环境变量，请将 `.env` 文件放在引用项目根目录下，并配置如下内容：

| 变量名 | 描述 | 默认 | 可选 |
| --- | --- | --- | --- |
| EDUSYS_OCR_URL | 验证码识别接口地址 | | 是 |
| EDUSYS_URL | 访问教务系统路径 | https://jw.tjustb.cn | 否 |
| EDUSYS_TIMEOUT | 请求超时时间(秒数) | 5 | 否 |

## 适用学校系统

以本校 2017 强智教务为目标抓包分析开发而来，其余院校无法测试可用性未测试。各功能代码略有不同，如果您有类似需求，可 [联系我](mailto:admin@airmole.cn) 有偿开发专用特供版本。
