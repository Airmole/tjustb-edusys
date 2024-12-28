## 成绩相关API方法

---

- [获取成绩查询选项](#获取成绩查询选项)
- [获取成绩](#查询成绩)
- [学生获取培养方案](#学生获取培养方案)

---


### 获取成绩查询选项

获取成绩查询筛选选项列表

方法：`scoreQueryOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->scoreQueryOptions();
echo json_encode($list);
```

返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
    "time": [
        {
            "name": "全部学期",
            "value": ""
        },
        {
            "name": "2022-2023-1",
            "value": "2022-2023-1"
        },
        {
            "name": "2021-2022-2",
            "value": "2021-2022-2"
        },
        {
            "name": "2021-2022-1",
            "value": "2021-2022-1"
        },
        {
            "name": "2020-2021-2",
            "value": "2020-2021-2"
        },
        {
            "name": "2020-2021-1",
            "value": "2020-2021-1"
        },
        {
            "name": "2019-2020-2",
            "value": "2019-2020-2"
        },
        {
            "name": "2019-2020-1",
            "value": "2019-2020-1"
        },
        {
            "name": "2018-2019-2",
            "value": "2018-2019-2"
        },
        {
            "name": "2018-2019-1",
            "value": "2018-2019-1"
        },
        {
            "name": "2017-2018-2",
            "value": "2017-2018-2"
        },
        {
            "name": "2017-2018-1",
            "value": "2017-2018-1"
        },
        {
            "name": "2016-2017-3",
            "value": "2016-2017-3"
        },
        {
            "name": "2016-2017-2",
            "value": "2016-2017-2"
        },
        {
            "name": "2016-2017-1",
            "value": "2016-2017-1"
        },
        {
            "name": "2015-2016-3",
            "value": "2015-2016-3"
        },
        {
            "name": "2015-2016-2",
            "value": "2015-2016-2"
        },
        {
            "name": "2015-2016-1",
            "value": "2015-2016-1"
        },
        {
            "name": "2014-2015-3",
            "value": "2014-2015-3"
        },
        {
            "name": "2014-2015-2",
            "value": "2014-2015-2"
        },
        {
            "name": "2014-2015-1",
            "value": "2014-2015-1"
        },
        {
            "name": "2013-2014-3",
            "value": "2013-2014-3"
        },
        {
            "name": "2013-2014-2",
            "value": "2013-2014-2"
        },
        {
            "name": "2013-2014-1",
            "value": "2013-2014-1"
        },
        {
            "name": "2012-2013-3",
            "value": "2012-2013-3"
        },
        {
            "name": "2012-2013-2",
            "value": "2012-2013-2"
        },
        {
            "name": "2012-2013-1",
            "value": "2012-2013-1"
        },
        {
            "name": "2011-2012-2",
            "value": "2011-2012-2"
        },
        {
            "name": "2011-2012-1",
            "value": "2011-2012-1"
        },
        {
            "name": "2010-2011-3",
            "value": "2010-2011-3"
        },
        {
            "name": "2010-2011-2",
            "value": "2010-2011-2"
        },
        {
            "name": "2010-2011-1",
            "value": "2010-2011-1"
        },
        {
            "name": "2010-2011-0",
            "value": "2010-2011-0"
        },
        {
            "name": "2009-2010-3",
            "value": "2009-2010-3"
        },
        {
            "name": "2009-2010-2",
            "value": "2009-2010-2"
        },
        {
            "name": "2009-2010-1",
            "value": "2009-2010-1"
        },
        {
            "name": "2009-2010-0",
            "value": "2009-2010-0"
        },
        {
            "name": "2008-2009-3",
            "value": "2008-2009-3"
        },
        {
            "name": "2008-2009-2",
            "value": "2008-2009-2"
        },
        {
            "name": "2008-2009-1",
            "value": "2008-2009-1"
        },
        {
            "name": "2007-2008-3",
            "value": "2007-2008-3"
        },
        {
            "name": "2007-2008-2",
            "value": "2007-2008-2"
        },
        {
            "name": "2007-2008-1",
            "value": "2007-2008-1"
        },
        {
            "name": "2006-2007-3",
            "value": "2006-2007-3"
        },
        {
            "name": "2006-2007-2",
            "value": "2006-2007-2"
        },
        {
            "name": "2006-2007-1",
            "value": "2006-2007-1"
        },
        {
            "name": "2005-2006-2",
            "value": "2005-2006-2"
        },
        {
            "name": "2005-2006-1",
            "value": "2005-2006-1"
        },
        {
            "name": "2004-2005-2",
            "value": "2004-2005-2"
        },
        {
            "name": "2004-2005-1",
            "value": "2004-2005-1"
        },
        {
            "name": "2003-2004-2",
            "value": "2003-2004-2"
        },
        {
            "name": "2003-2004-1",
            "value": "2003-2004-1"
        },
        {
            "name": "2002-2003-2",
            "value": "2002-2003-2"
        },
        {
            "name": "2002-2003-1",
            "value": "2002-2003-1"
        },
        {
            "name": "2001-2002-2",
            "value": "2001-2002-2"
        },
        {
            "name": "2001-2002-1",
            "value": "2001-2002-1"
        },
        {
            "name": "2000-2001-2",
            "value": "2000-2001-2"
        },
        {
            "name": "2000-2001-1",
            "value": "2000-2001-1"
        }
    ],
    "nature": [
        {
            "name": "---请选择---",
            "value": ""
        },
        {
            "name": "人文社科课",
            "value": "01"
        },
        {
            "name": "学科基础课",
            "value": "02"
        },
        {
            "name": "创新创业课",
            "value": "03"
        },
        {
            "name": "实践教学课",
            "value": "04"
        },
        {
            "name": "专业选修课",
            "value": "05"
        },
        {
            "name": "公共选修课",
            "value": "06"
        },
        {
            "name": "数学自然课",
            "value": "07"
        },
        {
            "name": "专业必修课",
            "value": "08"
        },
        {
            "name": "必修考察课",
            "value": "09"
        },
        {
            "name": "专业核心课",
            "value": "14"
        },
        {
            "name": "专业方向课",
            "value": "15"
        },
        {
            "name": "职业发展课",
            "value": "16"
        },
        {
            "name": "集中实践课",
            "value": "18"
        },
        {
            "name": "其他",
            "value": "99"
        }
    ],
    "show": [
        {
            "name": "显示全部成绩",
            "value": "all"
        },
        {
            "name": "显示最好成绩",
            "value": "max"
        }
    ]
}
```

</details>

----

### 查询成绩

方法：`score()`

参数：

| para     | type   | nullable | default | tips                       |
| -------- | ------ |:--------:| ------- | -------------------------- |
| time     | string | ✅        | ''      | 开课学期                       |
| nature   | string | ✅        | ''      | 课程性质                       |
| course   | string | ✅        | ''      | 课程名称                       |
| show     | string | ✅        | all     | 显示方式：all-显示全部成绩,max-显示最好成绩 |
| classify | bool   | ✅        | true    | 是否按学期分类计算平均分               |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->score();
echo json_encode($list);
```

返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
  "summary": {
    "courseNum": "22",
    "creditSum": "55.5",
    "gpaAvg": "0",
    "scoreAvg": "75.68"
  },
  "data": {
    "2022-2023-1": {
      "items": [
        {
          "SerialNo": "22",
          "courseSemester": "2022-2023-1",
          "courseCode": "X075005",
          "courseName": "临床营养学",
          "groupName": "",
          "score": "83",
          "scoreMark": "",
          "credit": "1.5",
          "period": "24",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考查",
          "examNature": "正常考试",
          "courseType": "限选",
          "courseNature": "专业选修课",
          "courseCategory": ""
        }
      ],
      "total": 83,
      "avg": "83.00",
      "gpa": "83.00",
      "semester": "2022-2023-1"
    },
    "2021-2022-2": {
      "items": [
        {
          "SerialNo": "21",
          "courseSemester": "2021-2022-2",
          "courseCode": "X075001",
          "courseName": "中医学基础",
          "groupName": "",
          "score": "83",
          "scoreMark": "",
          "credit": "3.5",
          "period": "56",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考查",
          "examNature": "正常考试",
          "courseType": "限选",
          "courseNature": "专业选修课",
          "courseCategory": ""
        },
        {
          "SerialNo": "20",
          "courseSemester": "2021-2022-2",
          "courseCode": "S031001",
          "courseName": "劳动实践课",
          "groupName": "",
          "score": "82",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "其它",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "实践教学课",
          "courseCategory": ""
        },
        {
          "SerialNo": "19",
          "courseSemester": "2021-2022-2",
          "courseCode": "B075030",
          "courseName": "功能解剖学",
          "groupName": "",
          "score": "79",
          "scoreMark": "",
          "credit": "4",
          "period": "64",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "专业必修课",
          "courseCategory": ""
        },
        {
          "SerialNo": "18",
          "courseSemester": "2021-2022-2",
          "courseCode": "B075004",
          "courseName": "康复医学概论",
          "groupName": "",
          "score": "75",
          "scoreMark": "",
          "credit": "1.5",
          "period": "24",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考查",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "学科基础课",
          "courseCategory": ""
        },
        {
          "SerialNo": "17",
          "courseSemester": "2021-2022-2",
          "courseCode": "B075003",
          "courseName": "生物化学",
          "groupName": "",
          "score": "87",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考查",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "学科基础课",
          "courseCategory": ""
        },
        {
          "SerialNo": "16",
          "courseSemester": "2021-2022-2",
          "courseCode": "B075002",
          "courseName": "生理学",
          "groupName": "",
          "score": "66",
          "scoreMark": "",
          "credit": "4",
          "period": "64",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "学科基础课",
          "courseCategory": ""
        },
        {
          "SerialNo": "15",
          "courseSemester": "2021-2022-2",
          "courseCode": "B0520131",
          "courseName": "形势与政策I",
          "groupName": "",
          "score": "75",
          "scoreMark": "",
          "credit": "0.5",
          "period": "16",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "14",
          "courseSemester": "2021-2022-2",
          "courseCode": "B052011",
          "courseName": "中国近现代史纲要",
          "groupName": "",
          "score": "79",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "13",
          "courseSemester": "2021-2022-2",
          "courseCode": "B052005",
          "courseName": "大学生心理健康",
          "groupName": "",
          "score": "76",
          "scoreMark": "",
          "credit": "1",
          "period": "16",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "12",
          "courseSemester": "2021-2022-2",
          "courseCode": "B0430012",
          "courseName": "体育II",
          "groupName": "43网球",
          "score": "75",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "11",
          "courseSemester": "2021-2022-2",
          "courseCode": "B0410072",
          "courseName": "基础外语AII",
          "groupName": "",
          "score": "68",
          "scoreMark": "",
          "credit": "4",
          "period": "64",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        }
      ],
      "total": 845,
      "avg": "76.82",
      "gpa": "76.02",
      "semester": "2021-2022-2"
    },
    "2021-2022-1": {
      "items": [
        {
          "SerialNo": "10",
          "courseSemester": "2021-2022-1",
          "courseCode": "S052001",
          "courseName": "思想政治理论课实践",
          "groupName": "",
          "score": "合格",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "实践教学课",
          "courseCategory": ""
        },
        {
          "SerialNo": "9",
          "courseSemester": "2021-2022-1",
          "courseCode": "B075006",
          "courseName": "人体运动学（含生物力学）",
          "groupName": "",
          "score": "67",
          "scoreMark": "",
          "credit": "3.5",
          "period": "56",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "专业必修课",
          "courseCategory": ""
        },
        {
          "SerialNo": "8",
          "courseSemester": "2021-2022-1",
          "courseCode": "B075005",
          "courseName": "人体发育学",
          "groupName": "",
          "score": "76",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考查",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "专业必修课",
          "courseCategory": ""
        },
        {
          "SerialNo": "7",
          "courseSemester": "2021-2022-1",
          "courseCode": "B075001",
          "courseName": "人体形态学",
          "groupName": "",
          "score": "68",
          "scoreMark": "",
          "credit": "5",
          "period": "80",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "学科基础课",
          "courseCategory": ""
        },
        {
          "SerialNo": "6",
          "courseSemester": "2021-2022-1",
          "courseCode": "B053013",
          "courseName": "大学计算机基础A",
          "groupName": "",
          "score": "87",
          "scoreMark": "",
          "credit": "3",
          "period": "48",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "数学自然课",
          "courseCategory": ""
        },
        {
          "SerialNo": "5",
          "courseSemester": "2021-2022-1",
          "courseCode": "B052014",
          "courseName": "思想道德与法治",
          "groupName": "",
          "score": "77",
          "scoreMark": "",
          "credit": "3",
          "period": "48",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "4",
          "courseSemester": "2021-2022-1",
          "courseCode": "B052006",
          "courseName": "军事理论",
          "groupName": "",
          "score": "72",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "3",
          "courseSemester": "2021-2022-1",
          "courseCode": "B0430011",
          "courseName": "体育I",
          "groupName": "排球",
          "score": "65",
          "scoreMark": "",
          "credit": "2",
          "period": "32",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "2",
          "courseSemester": "2021-2022-1",
          "courseCode": "B0410071",
          "courseName": "基础外语AI",
          "groupName": "",
          "score": "73",
          "scoreMark": "",
          "credit": "4",
          "period": "64",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        },
        {
          "SerialNo": "1",
          "courseSemester": "2021-2022-1",
          "courseCode": "B0280011",
          "courseName": "大学生职业发展与就业指导I",
          "groupName": "",
          "score": "86",
          "scoreMark": "",
          "credit": "1",
          "period": "16",
          "scorePoint": "",
          "refixTream": "",
          "accessMethod": "考试",
          "examNature": "正常考试",
          "courseType": "必修",
          "courseNature": "人文社科课",
          "courseCategory": ""
        }
      ],
      "total": 671,
      "avg": "74.56",
      "gpa": "73.35",
      "semester": "2021-2022-1"
    }
  }
}
```

</details>

<details>
  <summary>无成绩参数示例</summary>

```json
{
    "summary": [],
    "data": []
}
```

</details>

---


### 学生获取培养方案

> 仅学生账号可用

方法：`trainingPlan()`


<details>
  <summary>返回参数示例</summary>

```json
{
  "title": "2015版本计算机科学与技术培养方案培养方案及教学计划",
  "cultivateTarget": "2015版本计算机科学与技术培养目标",
  "decription": "2015版本计算机科学与技术培养方案",
  "courseList": {
    "content": [
      {
        "courseSystem": {
          "title": "专业选修课",
          "due": "0",
          "existing": "27"
        },
        "summary": {
          "credit": "85",
          "lectureHours": "710",
          "experimentalHours": "296",
          "designHours": "0",
          "computerHours": "124",
          "otherHours": "0",
          "practicalHours": "230",
          "totalHours": "1360"
        },
        "items": [
          {
            "group": "",
            "courseCode": "X053001",
            "courseName": "实用软件工程",
            "completion": null,
            "courseNature": "专业选修课",
            "courseType": "限选",
            "credit": "2",
            "lectureHours": "32",
            "experimentalHours": "0",
            "designHours": "0",
            "computerHours": "0",
            "otherHours": "0",
            "practicalHours": "0",
            "totalHours": "32",
            "term": "6"
          },
          {
            "group": "",
            "courseCode": "X053004",
            "courseName": "软件测试",
            "completion": {
              "status": "已修",
              "score": "86"
            },
            "courseNature": "专业选修课",
            "courseType": "限选",
            "credit": "2",
            "lectureHours": "24",
            "experimentalHours": "0",
            "designHours": "0",
            "computerHours": "8",
            "otherHours": "0",
            "practicalHours": "0",
            "totalHours": "32",
            "term": "6"
          }
        ]
      }
    ],
    "summary": {
      "termProgress": [
        {
          "term": "",
          "progress": "80.39"
        },
        {
          "term": "1",
          "progress": "100"
        },
        {
          "term": "2",
          "progress": "90.91"
        },
        {
          "term": "3",
          "progress": "92.31"
        },
        {
          "term": "4",
          "progress": "73.33"
        },
        {
          "term": "5",
          "progress": "76.92"
        },
        {
          "term": "6",
          "progress": "29.63"
        },
        {
          "term": "7",
          "progress": "100"
        },
        {
          "term": "8",
          "progress": "80"
        }
      ],
      "credit": 262,
      "lectureHours": 2458,
      "experimentalHours": 512,
      "designHours": 0,
      "computerHours": 408,
      "otherHours": 0,
      "practicalHours": 742,
      "totalHours": 4120
    }
  }
}
```

</details>