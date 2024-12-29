## 教师常用API方法

> 以下API方法仅教师账号可用

---

- [教师授课列表获取](#教师授课列表获取)
- [教师查询学生花名册](#教师查询学生花名册)
- [教师查询专业培养方案筛选项](#教师查询专业培养方案筛选项)
- [教师查询专业培养方案](#教师查询专业培养方案)

---

### 教师授课列表获取

> 获取授课列表

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

> 传入教师授课列表接口返回的queryCode，获取课堂学生花名册

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

### 教师查询专业培养方案筛选项

方法：`trainingPlanOptions($college, $grade, $profession)`

所需参数：

| para    | type   | nullable | default | tips          |
|---------| ------ |:--------:|-------|---------------|
| college | string |     ✅    |       | 院系，值获取自本接口返回值 |
| grade | string |     ✅    |       | 年级，值获取自本接口返回值 | 
| profession | string |     ✅    |       | 专业，值获取自本接口返回值 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '1234'; // 教师账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$options = $edusys->trainingPlanOptions();
echo json_encode($options);
```

<details>
  <summary>返回参数示例</summary>

```json
{
    "college": [
        {
            "name": "--请选择--",
            "value": "",
            "checked": false
        },
        {
            "name": "[011]土木工程系",
            "value": "011",
            "checked": false
        },
        {
            "name": "[051]信息工程系",
            "value": "051",
            "checked": true
        },
        {
            "name": "[052]人工智能系",
            "value": "992F8616295D40A5B7C5AEE84060B3DB",
            "checked": false
        },
        {
            "name": "[06]音乐系",
            "value": "06",
            "checked": false
        },
        {
            "name": "[062]舞蹈系",
            "value": "FA5BD4515C4C4FA0987A6FC97C1F94E9",
            "checked": false
        },
        {
            "name": "[071]经济系",
            "value": "071",
            "checked": false
        },
        {
            "name": "[08]法律系",
            "value": "08",
            "checked": false
        },
        {
            "name": "[09]外语系",
            "value": "09",
            "checked": false
        },
        {
            "name": "[10]无人机系",
            "value": "091A1730BF0E4621BD53DEFED59D756A",
            "checked": false
        },
        {
            "name": "[171]管理系",
            "value": "171",
            "checked": false
        },
        {
            "name": "[21]武装部",
            "value": "19E92A97E94D463587B72C954F33DAEF",
            "checked": false
        },
        {
            "name": "[27]实验室管理中心",
            "value": "27",
            "checked": false
        }
    ],
    "grade": [
        {
            "name": "--请选择--",
            "value": "",
            "checked": false
        },
        {
            "name": "2024",
            "value": "2024",
            "checked": false
        },
        {
            "name": "2023",
            "value": "2023",
            "checked": true
        },
        {
            "name": "2022",
            "value": "2022",
            "checked": false
        },
        {
            "name": "2021",
            "value": "2021",
            "checked": false
        }
    ],
    "profession": [
        {
            "name": "--请选择--",
            "value": "",
            "checked": false
        },
        {
            "name": "计算机科学与技术",
            "value": "0509BE51D4094AF39A12D0A2F1561712",
            "checked": true
        }
    ]
}
```

</details>

### 教师查询专业培养方案

方法：`professionTrainingPlan($grade, $profession, $page)`


| para    | type   | nullable | default | tips                     |
| --------| -------|----------|---------|--------------------------|
| grade | string |     ✅    |         | 年级，值获取自教师查询专业培养方案筛选项接口返回值 | 
| profession | string |     ✅    |         | 专业，值获取自教师查询专业培养方案筛选项接口返回值 |
| page | int |     ✅    | 1       | 页码             |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '1234'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->professionTrainingPlan('2023', '0509BE51D409...', 1);
echo json_encode($list);
```


<details>
  <summary>返回参数示例</summary>

```json
{
    "data": [
        {
            "no": "1",
            "term": "5",
            "profession": "计算机科学与技术",
            "courseCode": "J05122106",
            "courseName": "编译原理",
            "totalHours": "48",
            "credit": "3",
            "accessMethod": "考试",
            "department": "信息工程系",
            "referenceWeeklyHours": "2"
        },
        {
            "no": "2",
            "term": "5",
            "profession": "计算机科学与技术",
            "courseCode": "H05122107",
            "courseName": "Python高级应用",
            "totalHours": "32",
            "credit": "2",
            "accessMethod": "考试",
            "department": "信息工程系",
            "referenceWeeklyHours": "2"
        }
    ],
    "pagination": {
        "total": 105,
        "currentPage": 2,
        "totalPage": 3
    }
}
```

</details>