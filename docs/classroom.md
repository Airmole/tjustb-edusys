## 教学地点相关API方法

---

- [教室借用情况筛选项](#教室借用情况筛选项)
- [教学地点列表](#教学地点列表)
- [教室状态查询及详情所需参数](#教室状态查询及详情所需参数)
- [获取教室借用详情信息](#获取教室借用详情信息)

---


### 教室借用情况筛选项

方法：`classroomStatusOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->classroomStatusOptions();
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
{
    "semester": [
        {
            "name": "2022-2023-1",
            "value": "2022-2023-1",
            "checked": true
        }
    ],
    "schoolArea": [
        {
            "name": "-请选择-",
            "value": "",
            "checked": true
        },
        {
            "name": "本校区",
            "value": "01",
            "checked": false
        }
    ],
    "teachArea": [
        {
            "name": "-请选择-",
            "value": "",
            "checked": true
        }
    ],
    "classroomType": [
        {
            "name": "-请选择-",
            "value": "",
            "checked": true
        },
        {
            "name": "普通教室",
            "value": "01",
            "checked": false
        },
        {
            "name": "制图室",
            "value": "02",
            "checked": false
        },
        {
            "name": "实验室",
            "value": "03",
            "checked": false
        },
        {
            "name": "语音室",
            "value": "04",
            "checked": false
        },
        {
            "name": "多媒体教室",
            "value": "05",
            "checked": false
        },
        {
            "name": "计算机房",
            "value": "08",
            "checked": false
        },
        {
            "name": "体育场",
            "value": "10",
            "checked": false
        },
        {
            "name": "琴房",
            "value": "12",
            "checked": false
        },
        {
            "name": "画室",
            "value": "13",
            "checked": false
        },
        {
            "name": "体育馆",
            "value": "15",
            "checked": false
        },
        {
            "name": "体育场",
            "value": "16",
            "checked": false
        },
        {
            "name": "模拟法庭",
            "value": "29",
            "checked": false
        }
    ],
    "peopleSign": [
        {
            "name": "=",
            "value": "=",
            "checked": true
        },
        {
            "name": ">",
            "value": ">",
            "checked": false
        },
        {
            "name": ">=",
            "value": ">=",
            "checked": false
        },
        {
            "name": "<",
            "value": "<",
            "checked": false
        },
        {
            "name": "<=",
            "value": "<=",
            "checked": false
        },
        {
            "name": "<>",
            "value": "<>",
            "checked": false
        }
    ],
    "classroomStatus": [
        {
            "name": "-请选择-",
            "value": "",
            "checked": true
        },
        {
            "name": "M跨模式占用",
            "value": "9",
            "checked": false
        },
        {
            "name": "完全空闲",
            "value": "8",
            "checked": false
        },
        {
            "name": "Ｌ临时调课",
            "value": "7",
            "checked": false
        },
        {
            "name": "Ｇ固定调课",
            "value": "6",
            "checked": false
        },
        {
            "name": "空闲",
            "value": "5",
            "checked": false
        },
        {
            "name": "Κ考试",
            "value": "4",
            "checked": false
        },
        {
            "name": "Ｘ锁定",
            "value": "3",
            "checked": false
        },
        {
            "name": "Ｊ借用",
            "value": "2",
            "checked": false
        },
        {
            "name": "◆正常上课",
            "value": "1",
            "checked": false
        }
    ],
    "borrowCollege": [
        {
            "name": "--请选择--",
            "value": "",
            "checked": true
        },
        {
            "name": "[011]土木工程系",
            "value": "011",
            "checked": false
        },
        {
            "name": "[012]环境工程系",
            "value": "012",
            "checked": false
        },
        {
            "name": "[013]艺术设计系",
            "value": "013",
            "checked": false
        },
        {
            "name": "[02]护理系",
            "value": "02",
            "checked": false
        },
        {
            "name": "[022]康复治疗系",
            "value": "1669097690654C2697E66260C1E678C9",
            "checked": false
        },
        {
            "name": "[03]材料科学与工程系",
            "value": "03",
            "checked": false
        },
        {
            "name": "[04]机械工程系",
            "value": "04",
            "checked": false
        },
        {
            "name": "[042]通信工程系",
            "value": "F367CE0C4668477DA1F3D59B52D1AC43",
            "checked": false
        },
        {
            "name": "[043]智能制造学院",
            "value": "DAD1F16577B44F8D9439402F4E8CEADB",
            "checked": false
        },
        {
            "name": "[051]信息工程系",
            "value": "051",
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
        },
        {
            "name": "[35]资产管理中心",
            "value": "547D47D5D53B4EB1AB09E6E551441C7E",
            "checked": false
        },
        {
            "name": "[36]保卫处",
            "value": "7BCD2332A8D04C108B01551417684BF9",
            "checked": false
        },
        {
            "name": "[43]体育部",
            "value": "43",
            "checked": false
        },
        {
            "name": "[44]思想政治部",
            "value": "44",
            "checked": false
        },
        {
            "name": "[45]公共教学部",
            "value": "45",
            "checked": false
        },
        {
            "name": "[46]劳动学院",
            "value": "8D689F95650644F5B873356BFB248084",
            "checked": false
        },
        {
            "name": "[52]基础部",
            "value": "52",
            "checked": false
        }
    ],
    "timeModel": [
        {
            "name": "默认节次模式",
            "value": "9473F3E0DCAB413BE0535BDCFA0AFB99",
            "checked": true
        }
    ],
    "classroomOwned": [
        {
            "name": "--请选择--",
            "value": "",
            "checked": true
        },
        {
            "name": "[011]土木工程系",
            "value": "011",
            "checked": false
        },
        {
            "name": "[012]环境工程系",
            "value": "012",
            "checked": false
        },
        {
            "name": "[013]艺术设计系",
            "value": "013",
            "checked": false
        },
        {
            "name": "[02]护理系",
            "value": "02",
            "checked": false
        },
        {
            "name": "[022]康复治疗系",
            "value": "1669097690654C2697E66260C1E678C9",
            "checked": false
        },
        {
            "name": "[03]材料科学与工程系",
            "value": "03",
            "checked": false
        },
        {
            "name": "[04]机械工程系",
            "value": "04",
            "checked": false
        },
        {
            "name": "[042]通信工程系",
            "value": "F367CE0C4668477DA1F3D59B52D1AC43",
            "checked": false
        },
        {
            "name": "[043]智能制造学院",
            "value": "DAD1F16577B44F8D9439402F4E8CEADB",
            "checked": false
        },
        {
            "name": "[051]信息工程系",
            "value": "051",
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
            "name": "[22]人事处",
            "value": "22",
            "checked": false
        },
        {
            "name": "[23]教务处",
            "value": "23",
            "checked": false
        },
        {
            "name": "[24]学生处",
            "value": "24",
            "checked": false
        },
        {
            "name": "[25]财务处",
            "value": "25",
            "checked": false
        },
        {
            "name": "[26]图书馆",
            "value": "26",
            "checked": false
        },
        {
            "name": "[27]实验室管理中心",
            "value": "27",
            "checked": false
        },
        {
            "name": "[28]招生就业处",
            "value": "28",
            "checked": false
        },
        {
            "name": "[29]现代教育中心",
            "value": "29",
            "checked": false
        },
        {
            "name": "[30]后勤处",
            "value": "30",
            "checked": false
        },
        {
            "name": "[31]基建产业处",
            "value": "31",
            "checked": false
        },
        {
            "name": "[32]科研处",
            "value": "32",
            "checked": false
        },
        {
            "name": "[33]国际交流处",
            "value": "33",
            "checked": false
        },
        {
            "name": "[34]学院办公室",
            "value": "34",
            "checked": false
        },
        {
            "name": "[35]资产管理中心",
            "value": "547D47D5D53B4EB1AB09E6E551441C7E",
            "checked": false
        },
        {
            "name": "[36]保卫处",
            "value": "7BCD2332A8D04C108B01551417684BF9",
            "checked": false
        },
        {
            "name": "[43]体育部",
            "value": "43",
            "checked": false
        },
        {
            "name": "[44]思想政治部",
            "value": "44",
            "checked": false
        },
        {
            "name": "[45]公共教学部",
            "value": "45",
            "checked": false
        },
        {
            "name": "[46]劳动学院",
            "value": "8D689F95650644F5B873356BFB248084",
            "checked": false
        },
        {
            "name": "[52]基础部",
            "value": "52",
            "checked": false
        },
        {
            "name": "[82]产学研协同创新研究院",
            "value": "82",
            "checked": false
        },
        {
            "name": "[83]环境研究所",
            "value": "83",
            "checked": false
        }
    ]
}
```

</details>

---

### 教学地点列表

> 教学区、教学楼、教室地点列表获取

方法：`classroomList()`

所需参数：

| para | type   | nullable | default   | tips                                  |
| ---- | ------ |:--------:| --------- |---------------------------------------|
| type | string | ✅        | classroom | 类型：area-教学区，building-教学楼，classroom-教室 |
| buildingId | string | ✅        |  | 教学楼ID                                 |


调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->classroomList('building');
// $list = $edusys->classroomList('classroom'， ’0109‘);
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    {
        "label": "1教",
        "value": "87C013A603BA4CA696757CBA7D24E8FD"
    },
    {
        "label": "2教",
        "value": "95DFFC43678F422C8BF8C60A6980CC46"
    },
    {
        "label": "3教",
        "value": "0103"
    },
    {
        "label": "5教",
        "value": "C3AD72ED6BBE4A7CBFA39D276ECE92A6"
    },
    {
        "label": "6教",
        "value": "0106"
    },
    {
        "label": "7教",
        "value": "0107"
    },
    {
        "label": "8教",
        "value": "0108"
    },
    {
        "label": "9教",
        "value": "0109"
    },
    {
        "label": "10教",
        "value": "0110"
    },
    {
        "label": "11教",
        "value": "0111"
    },
    {
        "label": "12教",
        "value": "0112"
    },
    {
        "label": "体育馆",
        "value": "0113"
    },
    {
        "label": "众创空间",
        "value": "0114"
    },
    {
        "label": "图书馆",
        "value": "0115"
    },
    {
        "label": "活动中心",
        "value": "B4D48ACD8A54464090BD53D5F399B82B"
    },
    {
        "label": "行政楼",
        "value": "E3362904228A425085EE6DD897502E84"
    }
]
```

</details>

---

### 教室状态查询及详情所需参数

方法：`classroomStatus()`

所需参数：

| para            | type   | nullable | default | tips                                                 |
| --------------- | ------ |:--------:| ------- | ---------------------------------------------------- |
| semester        | string | ❌        | ''      | 学年学期，不可为空，例2022-2023-1                               |
| timeModel       | string | ❌        | ''      | 时间模式，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                   |
| schoolArea      | string | ✅        | ''      | 校区（空值即可，本校仅一个校区），后续若有变动请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取 |
| teachArea       | string | ✅        | ''      | 教学区（空值即可），后续若有变动请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取        |
| classroomType   | string | ✅        | ''      | 教室类型，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                   |
| teachBuilding   | string | ✅        | ''      | 教学楼，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                    |
| classroomCode   | string | ✅        | ''      | 教室编码，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                   |
| peopleSign      | string | ✅        | ''      | 容纳人数比较符号，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取               |
| peopleNum       | string | ✅        | ''      | 容纳人数比较数值，字符串型数字                                      |
| classroomStatus | string | ✅        | ''      | 教室状态，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                   |
| borrowCollege   | string | ✅        | ''      | 借用院系，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                   |
| weekStart       | string | ✅        | ''      | 开始周（值1~30）                                           |
| weekEnd         | string | ✅        | ''      | 结束周（值1~30）                                           |
| dayOfWeekStart  | string | ✅        | ''      | 开始星期几（值1~7）                                          |
| dayOfWeekEnd    | string | ✅        | ''      | 结束星期几（值1~7）                                          |
| serialNoStart   | string | ✅        | ''      | 开始节数                                                 |
| serialNoEnd     | string | ✅        | ''      | 结束节数                                                 |
| classroomOwned  | string | ✅        | ''      | 教室所属单位，请求[教室借用情况筛选项](#教室借用情况筛选项)接口获取                 |

> 若请求参数有误，接口返回可能为空数组，但并不代表所传入参数正确，请自行检查参数。

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->classroomStatus(
    '2022-2023-1',
    '9473F3E0DCAB413BE0535BDCFA0AFB99',
    '',
    '',
    '12',
);
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
{
  "params": {
    "startZc": "",
    "endZc": "",
    "startJc": "",
    "endJc": "",
    "startXq": "1",
    "endXq": "7",
    "jszt": "",
    "xnxqh": "2022-2023-1",
    "kbjcmsid": "9473F3E0DCAB413BE0535BDCFA0AFB99",
    "syjs0601id": ""
  },
  "classroom": [
    {
      "classroom": " 合唱排练厅",
      "items": [
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10102",
              "dayOfWeek": 1,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期一"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10304",
              "dayOfWeek": 2,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期二"
        },
        {
          "items": [
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "◆",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10506",
              "dayOfWeek": 3,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期三"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10708",
              "dayOfWeek": 4,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期四"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "10910",
              "dayOfWeek": 5,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期五"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "1111213",
              "dayOfWeek": 6,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期六"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "2FD62AB4F9FF464B9DD7E8DDC2294905",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期日"
        }
      ]
    },
    {
      "classroom": " 弘艺音乐厅",
      "items": [
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "◆",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20102",
              "dayOfWeek": 1,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期一"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20304",
              "dayOfWeek": 2,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期二"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20506",
              "dayOfWeek": 3,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期三"
        },
        {
          "items": [
            {
              "content": "Κ◆",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "◆",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20708",
              "dayOfWeek": 4,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期四"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "◆Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "◆Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "20910",
              "dayOfWeek": 5,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期五"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "Ｊ",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "2111213",
              "dayOfWeek": 6,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期六"
        },
        {
          "items": [
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "08:00",
              "endAt": "09:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "09:55",
              "endAt": "11:30"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "13:10",
              "endAt": "14:45"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "15:00",
              "endAt": "16:35"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "16:50",
              "endAt": "18:25"
            },
            {
              "content": "",
              "classroomCode": "C006DC9FB320469C90FD7018C17842D1",
              "serialValue": "",
              "dayOfWeek": 7,
              "startAt": "19:10",
              "endAt": "21:35"
            }
          ],
          "title": "星期日"
        }
      ]
    }
  ]
}
```

</details>

---

### 获取教室借用详情信息

方法：`classroomDetail()`

所需参数：

| para            | type   | nullable | default | tips                                         |
| --------------- | ------ |:--------:| ------- | -------------------------------------------- |
| semester        | string | ❌        | ''      | 学年学期，不可为空，例2022-2023-1                       |
| timeModel       | string | ❌        | ''      | 时间模式，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取   |
| classroomCode   | string | ❌        | ''      | 教室编码，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取   |
| serialValue     | string | ❌        | ''      | 使用节次值，，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取 |
| dayOfWeek       | string | ❌        | ''      | 星期几（字符串数字值1-7）                               |
| startAt         | string | ❌        | ''      | 开始时间点，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取  |
| endAt           | string | ❌        | ''      | 结束时间点，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取  |
| dayOfWeekStart  | string | ✅        | 1       | 开始星期几（字符串数字值1~7）                             |
| dayOfWeekEnd    | string | ✅        | 7       | 结束星期几（字符串数字值1~7）                             |
| weekStart       | string | ✅        | ''      | 开始周（字符串数字值1~30）                              |
| weekEnd         | string | ✅        | ''      | 结束周（字符串数字值1~30）                              |
| serialNoStart   | string | ✅        | ''      | 开始节数                                         |
| serialNoEnd     | string | ✅        | ''      | 结束节数                                         |
| classroomStatus | string | ✅        | ''      | 教室状态，请求[教室状态查询及详情所需参数](#教室状态查询及详情所需参数)接口获取   |

> 若请求参数有误，接口返回可能为空数组，但并不代表所传入参数正确，请自行检查参数。

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->classroomDetail(
    '2022-2023-1',
    '9473F3E0DCAB413BE0535BDCFA0AFB99',
    '2FD62AB4F9FF464B9DD7E8DDC2294905',
    '10304',
    '2',
    '13:10',
    '14:45'
);
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    [
        {
            "label": "教室状态：",
            "value": "正常上课"
        },
        {
            "label": "教室：",
            "value": "合唱排练厅"
        },
        {
            "label": "时间：",
            "value": "范璟玉"
        },
        {
            "label": "节次：",
            "value": "2"
        },
        {
            "label": "周次：",
            "value": "1-5,7-17"
        },
        {
            "label": "时间标志：",
            "value": "单双周"
        },
        {
            "label": "备注：",
            "value": ""
        },
        {
            "label": "申请人：",
            "value": ""
        },
        {
            "label": "课程：",
            "value": "合唱基础I"
        },
        {
            "label": "任课教师：",
            "value": "范璟玉"
        }
    ]
]
```

</details>

---