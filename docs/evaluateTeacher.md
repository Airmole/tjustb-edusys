## 学生评教相关API方法

> 1. 由于没有可供评教测试用的账号，目前仅支持查询，不支持提交评教操作；
>
> 2. 仅学生账号可使用获取以下评教接口。

---

- [获取需评教学期批次](#获取需评教学期批次)
- [获取评教课程列表](#获取评教课程列表)
- [获取评教课程详情](#获取评教课程详情)

---

### 获取需评教学期批次

方法：`needEvaluateSemester()`


调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$edusys = new Edusys();
$edusys->usercode = '123456789'; // 学生学号
$edusys->cookie = '...';         // cookie
$result = $edusys->needEvaluateSemester();
echo json_encode($result);
```


返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
  "data": [
    {
      "no": "1",
      "semester": "2024-2025-1",
      "evaluateType": "生评师",
      "evaluateBatch": "2024-2025-1学期评价",
      "startAt": "2024-11-04",
      "endAt": "2025-03-01",
      "url": "/jsxsd/xspj/xspj_list.do?pj0502id=A2FD55DA6E6246188FA084942461590E&pj01id=&xnxq01id=2024-2025-1"
    }
  ],
  "pagination": {
    "total": 1,
    "currentPage": 1,
    "totalPage": 1
  }
}
```

</details>

---

### 获取评教课程列表

方法：`needEvaluateCourse(string $semesterUrl)`

| para     | type   | nullable | default | tips |
| ---------| ------ | ---------|---------|------|
| semesterUrl | string | ❌ | | 值取 `needEvaluateSemester()` 方法返回 `url` |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$edusys = new Edusys();
$edusys->usercode = '123456789'; // 学生学号
$edusys->cookie = '...';         // cookie
$semester = $edusys->needEvaluateSemester();
$result = $edusys->needEvaluateCourse($semester['data'][0]['url']);
echo json_encode($result);
```

返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
  "data": [
    {
      "no": "1",
      "courseCode": "R143221013",
      "courseName": "体育III",
      "teacher": "刘传海",
      "evaluateType": "必修考察课",
      "score": "99",
      "evaluated": "是",
      "submited": "是",
      "url": "/jsxsd/xspj/xspj_edit.do?xnxq01id=2024-2025-1&pj01id=5CF53CE8EC034CF1BE16E194B7ED6865&pj0502id=A2FD55DA6E6246188FA084942461590E&jx02id=FFB21A6186464EA1984ACEB59D6402B9&jx0404id=202420251003923&xsflid=&zpf=99&type=view"
    },
    {
      "no": "12",
      "courseCode": "Z152221062",
      "courseName": "大学物理AII",
      "teacher": "王刚",
      "evaluateType": "必修考察课",
      "score": "97",
      "evaluated": "是",
      "submited": "是",
      "url": "/jsxsd/xspj/xspj_edit.do?xnxq01id=2024-2025-1&pj01id=5CF53CE8EC034CF1BE16E194B7ED6865&pj0502id=A2FD55DA6E6246188FA084942461590E&jx02id=97778F19A3E847BAB468CD5F5E09D432&jx0404id=202420251000006&xsflid=&zpf=97&type=view"
    }
  ],
  "pagination": {
    "total": 2,
    "currentPage": 1,
    "totalPage": 1
  }
}
```

</details>

### 获取评教课程详情

方法：`evaluateCourseDetail(string $courseUrl)`

| para     | type   | nullable | default | tips |
| ---------| ------ | ---------|---------|------|
| courseUrl | string | ❌ | | 值取 `needEvaluateCourse()` 方法返回 `url` |

调用示例：
```php
use Airmole\TjustbEdusys\Edusys;

$edusys = new Edusys();
$edusys->usercode = '123456789'; // 学生学号
$edusys->cookie = '...';         // cookie
$semester = $edusys->needEvaluateSemester();
$list = $edusys->needEvaluateCourse($semester['data'][0]['url']);
$result = $edusys->evaluateCourseDetail($list['data'][1]['url']);
echo json_encode($result);
```



返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
  "courseName": "数据结构",
  "evaluateCategory": "生评师",
  "score": "71",
  "params": [
    {
      "name": "issubmit",
      "value": "0"
    },
    {
      "name": "sfxyt",
      "value": "0"
    },
    {
      "name": "pj09id",
      "value": "260D3101E362DB38E0635BDCFA0A1E3D"
    },
    {
      "name": "pj01id",
      "value": "5CF53CE8EC034CF1BE16E194B7ED6865"
    },
    {
      "name": "pj0502id",
      "value": "A2FD55DA6E6246188FA084942461590E"
    },
    {
      "name": "jg0101id",
      "value": ""
    },
    {
      "name": "jx0404id",
      "value": "202420251003541"
    },
    {
      "name": "xsflid",
      "value": ""
    },
    {
      "name": "xnxq01id",
      "value": "2024-2025-1"
    },
    {
      "name": "jx02id",
      "value": "7391CB9EA5C24E1AA4308867396575D1"
    },
    {
      "name": "pj02id",
      "value": "7657656A928642AA9C2B4BB7201A0F7E"
    },
    {
      "name": "xh",
      "value": ""
    }
  ],
  "form": [
    {
      "text": "遵纪守时，按时上下课；仪表端庄，精神饱满，讲课有热情；教学准备充分，内容熟练；作业布置适当，认真批改，安排辅导答疑，解答清楚。",
      "name": "pj06xh",
      "value": "1",
      "options": [
        {
          "text": "A+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "C7BF5599080F479D85A52DB83799FC02",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_C7BF5599080F479D85A52DB83799FC02",
            "value": "20"
          }
        },
        {
          "text": "A",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "A30E2F4FD2584013A3F8D59BBF6A43F4",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_A30E2F4FD2584013A3F8D59BBF6A43F4",
            "value": "19"
          }
        },
        {
          "text": "A-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "26AB0FD45360449A92D51237A95C8D2F",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_26AB0FD45360449A92D51237A95C8D2F",
            "value": "18"
          }
        },
        {
          "text": "B+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "08C38CB1A7C44B219D26AF23B8E1267D",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_08C38CB1A7C44B219D26AF23B8E1267D",
            "value": "17"
          }
        },
        {
          "text": "B",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "19D266AC731D4E00B32230533FCCE0C5",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_19D266AC731D4E00B32230533FCCE0C5",
            "value": "16"
          }
        },
        {
          "text": "B-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "C7F725FCD7084B9B8EF8C6D96E98A651",
            "checked": true
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_C7F725FCD7084B9B8EF8C6D96E98A651",
            "value": "15"
          }
        },
        {
          "text": "C+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "66CCFC1B2AF645609650ACF96D0D9205",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_66CCFC1B2AF645609650ACF96D0D9205",
            "value": "14"
          }
        },
        {
          "text": "C",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "BA9AA89B1BBC457688ADD6398F99EA31",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_BA9AA89B1BBC457688ADD6398F99EA31",
            "value": "13"
          }
        },
        {
          "text": "C-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_1",
            "value": "8AB3B72E4F764C9E94859D4F781F6607",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_1_8AB3B72E4F764C9E94859D4F781F6607",
            "value": "12"
          }
        }
      ]
    },
    {
      "text": "讲课语言流畅、思路清晰，逻辑清楚；联系实际讲解生动，有吸引力；重视课堂秩序管理，要求严格；有良好的课堂组织能力，善于与学生交流沟通。",
      "name": "pj06xh",
      "value": "5",
      "options": [
        {
          "text": "A+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "A0BCE10A24374DA398C8DE342166BFA2",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_A0BCE10A24374DA398C8DE342166BFA2",
            "value": "20"
          }
        },
        {
          "text": "A",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "EACA2EF5F0A7426EB08444EAE4FC755C",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_EACA2EF5F0A7426EB08444EAE4FC755C",
            "value": "19"
          }
        },
        {
          "text": "A-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "4383F527EF024E2FBA9E48A9DD817441",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_4383F527EF024E2FBA9E48A9DD817441",
            "value": "18"
          }
        },
        {
          "text": "B+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "23FE41BFF7724D1E8537C96E9662DD2F",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_23FE41BFF7724D1E8537C96E9662DD2F",
            "value": "17"
          }
        },
        {
          "text": "B",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "85D64BFE3C2A4D7CAE74294D3402AE4D",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_85D64BFE3C2A4D7CAE74294D3402AE4D",
            "value": "16"
          }
        },
        {
          "text": "B-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "FC29802BFD7C43A28DDAA146D64DA058",
            "checked": true
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_FC29802BFD7C43A28DDAA146D64DA058",
            "value": "15"
          }
        },
        {
          "text": "C+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "5576F07DDB1541A582DCFEE3AC39DEE6",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_5576F07DDB1541A582DCFEE3AC39DEE6",
            "value": "14"
          }
        },
        {
          "text": "C",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "31E3CA0DBC6F42CA9BC3B23B08D05CAE",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_31E3CA0DBC6F42CA9BC3B23B08D05CAE",
            "value": "13"
          }
        },
        {
          "text": "C-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_5",
            "value": "3B153568007C46C8AF2A53487D78824E",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_5_3B153568007C46C8AF2A53487D78824E",
            "value": "12"
          }
        }
      ]
    },
    {
      "text": "讲解重点突出、难点清楚；课程内容充实、信息量大；教材选用适当，学习资源丰富。",
      "name": "pj06xh",
      "value": "3",
      "options": [
        {
          "text": "A+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "50240A9168BC4403B272DFBF78C87DFF",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_50240A9168BC4403B272DFBF78C87DFF",
            "value": "20"
          }
        },
        {
          "text": "A",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "0940E23201404CEB83F515FA194021CC",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_0940E23201404CEB83F515FA194021CC",
            "value": "19"
          }
        },
        {
          "text": "A-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "74B5F59A7F544BDC829C8BDC7EBFFAA1",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_74B5F59A7F544BDC829C8BDC7EBFFAA1",
            "value": "18"
          }
        },
        {
          "text": "B+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "983E1C2FF22748D1BEC60A6373BDDDF8",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_983E1C2FF22748D1BEC60A6373BDDDF8",
            "value": "17"
          }
        },
        {
          "text": "B",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "7539A2F470BF42FDB6E7200B28391F12",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_7539A2F470BF42FDB6E7200B28391F12",
            "value": "16"
          }
        },
        {
          "text": "B-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "1D1622A447ED45C58A7D4CACB1AAF596",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_1D1622A447ED45C58A7D4CACB1AAF596",
            "value": "15"
          }
        },
        {
          "text": "C+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "1A6CF25A341B463789C06BAD801EFEB5",
            "checked": true
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_1A6CF25A341B463789C06BAD801EFEB5",
            "value": "14"
          }
        },
        {
          "text": "C",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "6CFEEB09FC974730917111CC0E9221CE",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_6CFEEB09FC974730917111CC0E9221CE",
            "value": "13"
          }
        },
        {
          "text": "C-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_3",
            "value": "148055B70291460480139FDB78658390",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_3_148055B70291460480139FDB78658390",
            "value": "12"
          }
        }
      ]
    },
    {
      "text": "教学手段运用恰当，注重引导与互动，课堂气氛活跃；合理运用现代化教育技术手段。",
      "name": "pj06xh",
      "value": "2",
      "options": [
        {
          "text": "A+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "6632591813884EBF853CA7D667668ABA",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_6632591813884EBF853CA7D667668ABA",
            "value": "20"
          }
        },
        {
          "text": "A",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "A3D8673EC15B4B65AE0E56B5CB573A1D",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_A3D8673EC15B4B65AE0E56B5CB573A1D",
            "value": "19"
          }
        },
        {
          "text": "A-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "2F035267BBA54EE3958AAA26DCE58177",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_2F035267BBA54EE3958AAA26DCE58177",
            "value": "18"
          }
        },
        {
          "text": "B+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "0353526FE7934431B49DC0A4680B7953",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_0353526FE7934431B49DC0A4680B7953",
            "value": "17"
          }
        },
        {
          "text": "B",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "4FE840AF82044880A750B2060A4990E8",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_4FE840AF82044880A750B2060A4990E8",
            "value": "16"
          }
        },
        {
          "text": "B-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "49BEE5C9267749BD850FC44614B18746",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_49BEE5C9267749BD850FC44614B18746",
            "value": "15"
          }
        },
        {
          "text": "C+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "481C78ACC21748EE8447079476FD0E9C",
            "checked": true
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_481C78ACC21748EE8447079476FD0E9C",
            "value": "14"
          }
        },
        {
          "text": "C",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "267E90CEE0074E5DB7C32AB91BC9787F",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_267E90CEE0074E5DB7C32AB91BC9787F",
            "value": "13"
          }
        },
        {
          "text": "C-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_2",
            "value": "2E1B0F350AFF49989B0F43D079344602",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_2_2E1B0F350AFF49989B0F43D079344602",
            "value": "12"
          }
        }
      ]
    },
    {
      "text": "使学生较好地理解并掌握主要教学内容；有利于启迪学生智慧，培养学生的应用能力、创新能力。",
      "name": "pj06xh",
      "value": "4",
      "options": [
        {
          "text": "A+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "0CC8118164B84EAFB536EECD01A10D04",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_0CC8118164B84EAFB536EECD01A10D04",
            "value": "20"
          }
        },
        {
          "text": "A",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "077242F32B3A454196DF1D2603D70587",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_077242F32B3A454196DF1D2603D70587",
            "value": "19"
          }
        },
        {
          "text": "A-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "3D15FCD957704942B2706A5ABF609100",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_3D15FCD957704942B2706A5ABF609100",
            "value": "18"
          }
        },
        {
          "text": "B+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "38E59AB4D8094EE9BE47F4EA24A5F9BD",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_38E59AB4D8094EE9BE47F4EA24A5F9BD",
            "value": "17"
          }
        },
        {
          "text": "B",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "329A8E1D3D36408EADA79D74F67D3AC9",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_329A8E1D3D36408EADA79D74F67D3AC9",
            "value": "16"
          }
        },
        {
          "text": "B-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "EB34EE20E62A4239A5FB8190DEF61969",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_EB34EE20E62A4239A5FB8190DEF61969",
            "value": "15"
          }
        },
        {
          "text": "C+",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "48208AD884634919A153506403170ECE",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_48208AD884634919A153506403170ECE",
            "value": "14"
          }
        },
        {
          "text": "C",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "6783D63150394F009EEA217FFA048086",
            "checked": true
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_6783D63150394F009EEA217FFA048086",
            "value": "13"
          }
        },
        {
          "text": "C-",
          "radio": {
            "type": "radio",
            "name": "pj0601id_4",
            "value": "8730A52CF12B4AA48FBE08F8239808D9",
            "checked": false
          },
          "hidden": {
            "type": "hidden",
            "name": "pj0601fz_4_8730A52CF12B4AA48FBE08F8239808D9",
            "value": "12"
          }
        }
      ]
    }
  ]
}
```

</details>