# Edusys常用API方法

---

- [获取登录所需参数](#获取登录所需参数)
- [手动登录](#手动登录)
- [自动登录](#自动登录)
- [注销登录](#注销登录)
- [修改密码](#修改密码)
- [获取资料信息](#获取资料信息)
- [获取照片](#获取照片)
- [课表相关方法](course.md)
- [成绩/分数相关方法](score.md)
- [教室/教学地点相关方法](classroom.md)
- [学生评教相关方法](evaluateTeacher.md)
- [教师账号相关方法](teacher.md)

---

### 获取登录所需参数

方法：`getLoginPara()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$edusys = new Edusys();
$para = $edusys->getLoginPara();
echo json_encode($para);
```

返回参数：

<details>
    <summary>查看响应示例：</summary>

```json
{
    "cookie": "JSESSIONID=7FEFD9BBCA4AF9366E59DC46B606E8D7; SERVERID=122",
    "captcha": "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"
}
```

</details>

---

### 手动登录

手动登录前需获取登录参数，人工识别输入验证码

方法：`selfLogin()`

所需参数：

| para     | type   | nullable | default | tips                                       |
|:-------- |:------:|:--------:|:-------:| ------------------------------------------ |
| usercode | string | ❌        | ❌       | 系统账号                                       |
| password | string | ❌        | ❌       | 系统密码                                       |
| captcha  | string | ❌        | ❌       | 验证码                                        |
| cookie   | string | ❌        | ❌       | cookie值，使用 [getLoginPara()](#获取登录所需参数)接口获取 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$loginPara = $edusys->getLoginPara(); // 获取登录所需参数：cookie，captcha
// $captchaText为验证码识别结果值
$login = $edusys->selfLogin($usercode, $password, $captchaText, $loginPara['cookie']);
echo json_encode($login); 
```

返回参数：

<details>
    <summary>登录成功返回参数示例</summary>

```json
{
  "code": 200,
  "data": "JSESSIONID=F61110129E60BB22E026E3A698A806E7; SERVERID=122"
}
```

</details>

<details>
    <summary>验证码错误返回参数示例</summary>

```json
{
  "code": 403,
  "data": "验证码错误"
}
```

</details>

<details>
    <summary>验证码不能为空错误返回参数示例</summary>

```json
{
  "code": 403,
  "data": "验证码不能为空"
}
```

</details>

<details>
    <summary>用户名或密码错误返回参数示例</summary>

```json
{
  "code": 403,
  "data": "用户名或密码错误"
}
```

</details>

<details>
    <summary>系统异常返回参数示例</summary>

```json
{
  "code": 500,
  "data": "系统异常,稍后再试"
}
```

</details>

---

### 自动登录

自动登录（仅需账号密码），但需要在您的项目根目录下配置`.env`文件配置 `EDUSYS_OCR_URL=http://captcha.ocr/`为您的验证码识别服务，本项目返回验证码为Base64图片字符。

方法：`autoLogin()`

所需参数：

| para     | type   | nullable | default | tips        |
|:-------- |:------ |:--------:|:-------:|:----------- |
| usercode | string | ❌        | ❌       | 系统账号        |
| password | string | ❌        | ❌       | 系统密码        |
| retry    | int    | ✅        | 1       | 验证码识别错误重试次数 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$login = $edusys->autoLogin($usercode, $password);
echo json_encode($login); 
```

返回参数：

> 与[手动登录](#手动登录)接口返回参数相同。

---

### 注销登录

方法：`logout()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$login = $edusys->autoLogin($usercode, $password);
$logout = $edusys->logout();
echo json_encode($logout); 
```

返回参数：

<details>
    <summary>返回参数示例</summary>

```json
{
  "code": 200,
  "data": "<html>.............." // 注销退出后跳转重定向页面HTML
}
```

</details>

---

### 修改密码

> 1. 只能修改当前登录账号密码
> 
> 2. 新旧密码不得相同
> 
> 3. 新秘密不得少于8位
> 
> 4. 密码同时包含字母数字

方法：`changePassword()`

所需参数：

| para      | type   | nullable | default | tips    |
| --------- | ------ | -------- | ------- | ------- |
| nowPwd    | string | ❌        | ❌       | 当前密码    |
| newPwd    | string | ❌        | ❌       | 新密码     |
| repeatPwd | string | ❌        | ❌       | 重复输入新密码 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$login = $edusys->autoLogin($usercode, $password);
$nowPwd = $password;
$newPwd = 'Testqazwsx123';
$repeatPwd = 'Testqazwsx123';
$reset = $edusys->changePassword($nowPwd, $newPwd, $repeatPwd);
echo json_encode($reset); 
```

返回参数：

> 同[注销登录接口](#注销登录)

---

### 获取资料信息

> v1.1.0版本起支持教工账号

方法：`profile()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$profile = $edusys->profile();
echo json_encode($profile); 
```

返回参数：

<details>
  <summary>返回参数示例(教师)</summary>

```json
{
    "usercode": "1234",
    "name": "张三",
    "gender": "男",
    "birthday": "1990-01-01",
    "country": "中国",
    "nation": "汉族",
    "idcardType": "身份证",
    "idcard": "000000000000000000",
    "jobType": "教学类",
    "teacherType": "专职教师",
    "workStatus": "在职",
    "health": "健康或良好",
    "college": "xxxxx系",
    "email": ""
}
```

</details>


<details>
  <summary>返回参数示例(学生)</summary>

```json
{
  "college": "信息工程系",
  "profession": "计算机科学与技术",
  "needStudyYear": "4",
  "className": "测1603",
  "usercode": "160366666",
  "name": "测试",
  "gender": "男",
  "namePinyin": "",
  "photo": "",
  "birthday": "1998-13-32",
  "marry": "",
  "mobile": "",
  "professionDirection": "",
  "politicalFace": "共青团员",
  "homeplace": "甘肃省",
  "joinPartyDate": "",
  "nation": "汉族",
  "studyForm": "",
  "studyLayer": "普通本科",
  "foreignLanguage": "",
  "homeAddress": "",
  "trainStation": "",
  "postcode": "",
  "homeTel": "",
  "contacter": "",
  "province": "",
  "city": "",
  "county": "",
  "joinSchoolDate": "201609",
  "graduateDate": "2020-06-24",
  "ceeCode": "161234567890",
  "idcard": "1234567890",
  "graduateCertNo": "",
  "bachelorCertNo": ""
}
```

</details>

----

### 获取照片

> 直接返回Base64字符串

方法：`photo()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$photo = $edusys->photo();
echo $photo;
```

返回参数：

<details>
  <summary>返回参数示例</summary>

```
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
```

</details>
