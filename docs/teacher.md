## 教师常用API方法

> 以下API方法仅教师账号可用

---

- [教师授课列表获取](#教师授课列表获取)
- [教师查询学生花名册](#教师查询学生花名册)

---


----


### 教师授课列表获取

> 仅教师账号可使用此方法，获取授课列表

方法：`teacherCourseList()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '1234'; // 教师账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->teacherCourseList();
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    {
        "title": "XXXX(H01312344)[10102]",
        "className": "XX2202班",
        "queryCode": "2023XXXXXXXXXX0"
    },
    {
        "title": "XXXX(H01312344)[10304]",
        "className": "XX2202班",
        "queryCode": "2023XXXXXXXXXX0"
    }
]
```

</details>

---

### 教师查询学生花名册

> 仅教师账号可用，传入教师授课列表接口返回的queryCode，获取课堂学生花名册

方法：`teacherQueryStudentList()`

所需参数：

| para | type   | nullable | default   | tips                                  |
| ---- | ------ |:--------:| --------- | ------------------------------------- |
| code | string | ❌        | null     | 传入教师授课列表接口返回的queryCode        |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '1234'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->teacherQueryStudentList('2023XXXXXXXXXX0');
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    {
        "no": "1",
        "major": "XXXXX系",
        "profession": "视觉传达设计",
        "grade": "2023",
        "className": "视传230X",
        "usercode": "23621XXXX",
        "name": "陈**",
        "gender": "男"
    },
    {
        "no": "2",
        "major": "XXXXX系",
        "profession": "视觉传达设计",
        "grade": "2023",
        "className": "视传230X",
        "usercode": "23621XXXX",
        "name": "陈**",
        "gender": "女"
    }
]
```

</details>
