## 课表相关API方法

---

- [获取个人学期课表](#获取个人学期课表)
- [个人学期课表查询选项](#个人学期课表筛选项列表)
- [获取某日周课表](#获取某日的周课表)
- [教学周历筛选项](#教学周历筛选项)
- [获取教学周历](#获取教学周历)
- [班级课表筛选项列表](#班级课表查询筛选项列表)
- [获取专业列表](#获取专业列表)
- [查询班级课表](#查询班级课表)
- [教师课表查询筛选项列表](#教师课表查询筛选项列表)
- [查询教师课表](#查询教师课表)
- [课程课表查询筛选项列表](#课程列表筛选详列表)
- [查询课程课表](#查询课程课表)

---

### 获取个人学期课表

方法：`semesterCourseTable()`

所需参数：

| para     | type   | nullable | default | tips                                  |
| -------- | ------ |:--------:|:-------:| ------------------------------------- |
| week     | string | ✅        | ''      | 上课周，值获取自[个人学期课表筛选项列表接口](#个人学期课表筛选项列表) |
| semester | string | ✅        | ''      | 学期，值获取自[个人学期课表筛选项列表接口](#个人学期课表筛选项列表)  |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$week = '6'; // 上课周
$semester = '2022-2023-1'; // 学期
$list = $edusys->semesterCourseTable($week, $semester);
echo json_encode($list);
```

返回参数：

<details>
  <summary>返回参数示例</summary>

```json
{
    "semester": "2022-2023-1",
    "week": "",
    "table": [
        {
            "title": "星期一",
            "items": [
                [],
                [
                    {
                        "courseName": "大学语文BI",
                        "teacher": "霍秀云",
                        "teachTime": "2,4,7,9,11,13,15,17(周)[03-04节]",
                        "teachWeek": "2,4,7,9,11,13,15,17",
                        "teachNo": "03-04",
                        "place": "8教406",
                        "startAt": "09:55",
                        "endAt": "11:30"
                    }
                ],
                [
                    {
                        "courseName": "大学计算机基础",
                        "teacher": "王琳",
                        "teachTime": "5(周)[05-06节]",
                        "teachWeek": "5",
                        "teachNo": "05-06",
                        "place": "10教304",
                        "startAt": "13:10",
                        "endAt": "14:45"
                    }
                ],
                [
                    {
                        "courseName": "高等数学BI",
                        "teacher": "梁登星",
                        "teachTime": "2-5,7-17(周)[07-08节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "07-08",
                        "place": "8教401",
                        "startAt": "15:00",
                        "endAt": "16:35"
                    }
                ],
                [
                    {
                        "courseName": "大学计算机基础",
                        "teacher": "王琳",
                        "teachTime": "2-4(周)[09-10节]",
                        "teachWeek": "2-4",
                        "teachNo": "09-10",
                        "place": "10教304",
                        "startAt": "16:50",
                        "endAt": "18:25"
                    }
                ],
                []
            ]
        },
        {
            "title": "星期二",
            "items": [
                [
                    {
                        "courseName": "基础外语AI",
                        "teacher": "秦丽波",
                        "teachTime": "2-5,7-17(周)[01-02节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "01-02",
                        "place": "8教202",
                        "startAt": "08:00",
                        "endAt": "09:35"
                    }
                ],
                [],
                [
                    {
                        "courseName": "微观经济学A",
                        "teacher": "万波琴",
                        "teachTime": "2-5,7-17(周)[05-06节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "05-06",
                        "place": "8教202",
                        "startAt": "13:10",
                        "endAt": "14:45"
                    }
                ],
                [],
                [],
                [
                    {
                        "courseName": "思想道德与法治",
                        "teacher": "孙超",
                        "teachTime": "2-5,7-17(周)[11-12节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "11-12",
                        "place": "8教102",
                        "startAt": "19:10",
                        "endAt": "21:35"
                    }
                ]
            ]
        },
        {
            "title": "星期三",
            "items": [
                [
                    {
                        "courseName": "大学计算机基础",
                        "teacher": "王琳",
                        "teachTime": "2-5,7-17(周)[01-02节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "01-02",
                        "place": "10教302",
                        "startAt": "08:00",
                        "endAt": "09:35"
                    }
                ],
                [
                    {
                        "courseName": "高等数学BI",
                        "teacher": "梁登星",
                        "teachTime": "2-5,7-17(周)[03-04节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "03-04",
                        "place": "8教401",
                        "startAt": "09:55",
                        "endAt": "11:30"
                    }
                ],
                [
                    {
                        "courseName": "体育I(33轮滑)",
                        "teacher": "董乐",
                        "teachTime": "2-5,7-17(周)[05-06节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "05-06",
                        "place": "",
                        "startAt": "13:10",
                        "endAt": "14:45"
                    }
                ],
                [],
                [],
                []
            ]
        },
        {
            "title": "星期四",
            "items": [
                [],
                [
                    {
                        "courseName": "劳动实践I",
                        "teacher": "王芳芳",
                        "teachTime": "17(周)[03-04节]",
                        "teachWeek": "17",
                        "teachNo": "03-04",
                        "place": "",
                        "startAt": "09:55",
                        "endAt": "11:30"
                    }
                ],
                [
                    {
                        "courseName": "微观经济学A",
                        "teacher": "万波琴",
                        "teachTime": "2-5,7-17(周)[05-06节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "05-06",
                        "place": "8教202",
                        "startAt": "13:10",
                        "endAt": "14:45"
                    }
                ],
                [
                    {
                        "courseName": "高等数学BI",
                        "teacher": "梁登星",
                        "teachTime": "3,5,8,10,12,14,16(周)[07-08节]",
                        "teachWeek": "3,5,8,10,12,14,16",
                        "teachNo": "07-08",
                        "place": "8教401",
                        "startAt": "15:00",
                        "endAt": "16:35"
                    }
                ],
                [],
                [
                    {
                        "courseName": "思想道德与法治",
                        "teacher": "孙超",
                        "teachTime": "2,4,7,9,11,13,15,17(周)[11-12节]",
                        "teachWeek": "2,4,7,9,11,13,15,17",
                        "teachNo": "11-12",
                        "place": "8教102",
                        "startAt": "19:10",
                        "endAt": "21:35"
                    }
                ]
            ]
        },
        {
            "title": "星期五",
            "items": [
                [
                    {
                        "courseName": "基础外语AI",
                        "teacher": "秦丽波",
                        "teachTime": "2-5,7-17(周)[01-02节]",
                        "teachWeek": "2-5,7-17",
                        "teachNo": "01-02",
                        "place": "8教301",
                        "startAt": "08:00",
                        "endAt": "09:35"
                    }
                ],
                [],
                [],
                [
                    {
                        "courseName": "职业生涯规划",
                        "teacher": "屈扬",
                        "teachTime": "9-12(周)[07-08-09-10节]",
                        "teachWeek": "9-12",
                        "teachNo": "07-08-09-10",
                        "place": "8教202",
                        "startAt": "15:00",
                        "endAt": "16:35"
                    }
                ],
                [
                    {
                        "courseName": "职业生涯规划",
                        "teacher": "屈扬",
                        "teachTime": "9-12(周)[07-08-09-10节]",
                        "teachWeek": "9-12",
                        "teachNo": "07-08-09-10",
                        "place": "8教202",
                        "startAt": "16:50",
                        "endAt": "18:25"
                    }
                ],
                []
            ]
        },
        {
            "title": "星期六",
            "items": [
                [],
                [],
                [],
                [],
                [],
                []
            ]
        },
        {
            "title": "星期日",
            "items": [
                [],
                [],
                [],
                [],
                [],
                []
            ]
        }
    ],
    "columnTitle": [
        "星期一",
        "星期二",
        "星期三",
        "星期四",
        "星期五",
        "星期六",
        "星期日"
    ],
    "rowTitle": [
        "08:00-09:35",
        "09:55-11:30",
        "13:10-14:45",
        "15:00-16:35",
        "16:50-18:25",
        "19:10-21:35",
        "备注:"
    ],
    "tips": "备注:劳动实践I王芳芳17周;"
}
```

</details>

---

### 个人学期课表筛选项列表

方法：`courseTableOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->courseTableOptions();
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
{
    "week": [
        {
            "name": "(全部)",
            "value": ""
        },
        {
            "name": "第1周",
            "value": "1"
        },
        {
            "name": "第2周",
            "value": "2"
        },
        {
            "name": "第3周",
            "value": "3"
        },
        {
            "name": "第4周",
            "value": "4"
        },
        {
            "name": "第5周",
            "value": "5"
        },
        {
            "name": "第6周",
            "value": "6"
        },
        {
            "name": "第7周",
            "value": "7"
        },
        {
            "name": "第8周",
            "value": "8"
        },
        {
            "name": "第9周",
            "value": "9"
        },
        {
            "name": "第10周",
            "value": "10"
        },
        {
            "name": "第11周",
            "value": "11"
        },
        {
            "name": "第12周",
            "value": "12"
        },
        {
            "name": "第13周",
            "value": "13"
        },
        {
            "name": "第14周",
            "value": "14"
        },
        {
            "name": "第15周",
            "value": "15"
        },
        {
            "name": "第16周",
            "value": "16"
        },
        {
            "name": "第17周",
            "value": "17"
        },
        {
            "name": "第18周",
            "value": "18"
        },
        {
            "name": "第19周",
            "value": "19"
        },
        {
            "name": "第20周",
            "value": "20"
        },
        {
            "name": "第21周",
            "value": "21"
        },
        {
            "name": "第22周",
            "value": "22"
        },
        {
            "name": "第23周",
            "value": "23"
        },
        {
            "name": "第24周",
            "value": "24"
        },
        {
            "name": "第25周",
            "value": "25"
        },
        {
            "name": "第26周",
            "value": "26"
        },
        {
            "name": "第27周",
            "value": "27"
        },
        {
            "name": "第28周",
            "value": "28"
        },
        {
            "name": "第29周",
            "value": "29"
        },
        {
            "name": "第30周",
            "value": "30"
        }
    ],
    "semester": [
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
    ]
}
```

</details>

---

### 获取某日的周课表

获取某日所在周的周课表

方法：`dateCourseTable()`

所需参数：

| para | type   | nullable | default       | tips            |
| ---- | ------ | -------- | ------------- | --------------- |
| date | string | ✅        | date('Y-m-d') | 日期，Y-m-d日期，默认当天 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$date = '2022-10-24';
$list = $edusys->dateCourseTable($date);
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
{
    "table": [
        {
            "title": "星期一",
            "items": [
                [],
                [],
                [],
                {
                    "courseName": "高等数学BI",
                    "teachTime": "第10周星期一[07-08]节",
                    "teachWeek": "第10周",
                    "teachNo": "07-08",
                    "place": "8教401",
                    "dayOfWeek": "星期一",
                    "startAt": "15:00",
                    "endAt": "16:35"
                },
                [],
                []
            ]
        },
        {
            "title": "星期二",
            "items": [
                {
                    "courseName": "基础外语AI",
                    "teachTime": "第10周星期二[01-02]节",
                    "teachWeek": "第10周",
                    "teachNo": "01-02",
                    "place": "8教202",
                    "dayOfWeek": "星期二",
                    "startAt": "08:00",
                    "endAt": "09:35"
                },
                [],
                {
                    "courseName": "微观经济学A",
                    "teachTime": "第10周星期二[05-06]节",
                    "teachWeek": "第10周",
                    "teachNo": "05-06",
                    "place": "8教202",
                    "dayOfWeek": "星期二",
                    "startAt": "13:10",
                    "endAt": "14:45"
                },
                [],
                [],
                {
                    "courseName": "思想道德与法治",
                    "teachTime": "第10周星期二[11-12]节",
                    "teachWeek": "第10周",
                    "teachNo": "11-12",
                    "place": "8教102",
                    "dayOfWeek": "星期二",
                    "startAt": "19:10",
                    "endAt": "21:35"
                }
            ]
        },
        {
            "title": "星期三",
            "items": [
                {
                    "courseName": "大学计算机基础",
                    "teachTime": "第10周星期三[01-02]节",
                    "teachWeek": "第10周",
                    "teachNo": "01-02",
                    "place": "10教302",
                    "dayOfWeek": "星期三",
                    "startAt": "08:00",
                    "endAt": "09:35"
                },
                {
                    "courseName": "高等数学BI",
                    "teachTime": "第10周星期三[03-04]节",
                    "teachWeek": "第10周",
                    "teachNo": "03-04",
                    "place": "8教401",
                    "dayOfWeek": "星期三",
                    "startAt": "09:55",
                    "endAt": "11:30"
                },
                {
                    "courseName": "体育I（33轮滑）",
                    "teachTime": "第10周星期三[05-06]节",
                    "teachWeek": "第10周",
                    "teachNo": "05-06",
                    "place": "分组名：33轮滑",
                    "dayOfWeek": "星期三",
                    "startAt": "13:10",
                    "endAt": "14:45"
                },
                [],
                [],
                []
            ]
        },
        {
            "title": "星期四",
            "items": [
                [],
                [],
                {
                    "courseName": "微观经济学A",
                    "teachTime": "第10周星期四[05-06]节",
                    "teachWeek": "第10周",
                    "teachNo": "05-06",
                    "place": "8教202",
                    "dayOfWeek": "星期四",
                    "startAt": "13:10",
                    "endAt": "14:45"
                },
                {
                    "courseName": "高等数学BI",
                    "teachTime": "第10周星期四[07-08]节",
                    "teachWeek": "第10周",
                    "teachNo": "07-08",
                    "place": "8教401",
                    "dayOfWeek": "星期四",
                    "startAt": "15:00",
                    "endAt": "16:35"
                },
                [],
                []
            ]
        },
        {
            "title": "星期五",
            "items": [
                {
                    "courseName": "基础外语AI",
                    "teachTime": "第10周星期五[01-02]节",
                    "teachWeek": "第10周",
                    "teachNo": "01-02",
                    "place": "8教301",
                    "dayOfWeek": "星期五",
                    "startAt": "08:00",
                    "endAt": "09:35"
                },
                [],
                [],
                {
                    "courseName": "职业生涯规划",
                    "teachTime": "第10周星期五[07-08-09-10]节",
                    "teachWeek": "第10周",
                    "teachNo": "07-08-09-10",
                    "place": "8教202",
                    "dayOfWeek": "星期五",
                    "startAt": "15:00",
                    "endAt": "16:35"
                },
                {
                    "courseName": "职业生涯规划",
                    "teachTime": "第10周星期五[07-08-09-10]节",
                    "teachWeek": "第10周",
                    "teachNo": "07-08-09-10",
                    "place": "8教202",
                    "dayOfWeek": "星期五",
                    "startAt": "16:50",
                    "endAt": "18:25"
                },
                []
            ]
        },
        {
            "title": "星期六",
            "items": [
                [],
                [],
                [],
                [],
                [],
                []
            ]
        },
        {
            "title": "星期日",
            "items": [
                [],
                [],
                [],
                [],
                [],
                []
            ]
        }
    ],
    "columnTitle": [
        "星期一",
        "星期二",
        "星期三",
        "星期四",
        "星期五",
        "星期六",
        "星期日"
    ],
    "rowTitle": [
        {
            "title": "第一大节",
            "time": "08:00-09:35",
            "startAt": "08:00",
            "endAt": "09:35"
        },
        {
            "title": "第二大节",
            "time": "09:55-11:30",
            "startAt": "09:55",
            "endAt": "11:30"
        },
        {
            "title": "第三大节",
            "time": "13:10-14:45",
            "startAt": "13:10",
            "endAt": "14:45"
        },
        {
            "title": "第四大节",
            "time": "15:00-16:35",
            "startAt": "15:00",
            "endAt": "16:35"
        },
        {
            "title": "第五大节",
            "time": "16:50-18:25",
            "startAt": "16:50",
            "endAt": "18:25"
        },
        {
            "title": "第六大节",
            "time": "19:10-21:35",
            "startAt": "19:10",
            "endAt": "21:35"
        }
    ],
    "nowWeek": "第10周",
    "endWeek": "22周",
    "tips": "第10周/22周",
    "date": "2022-11-05"
}
```

</details>

---

### 教学周历筛选项

教学周历查询筛选项列表

方法：`calendarOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->calendarOptions();
echo json_encode($list);
```

<details>
    <summary>数据返回示例</summary>

```json
{
    "semester": [
        {
            "value": "2022-2023-1",
            "name": "2022-2023-1"
        },
        {
            "value": "2021-2022-2",
            "name": "2021-2022-2"
        },
        {
            "value": "2021-2022-1",
            "name": "2021-2022-1"
        },
        {
            "value": "2020-2021-2",
            "name": "2020-2021-2"
        },
        {
            "value": "2020-2021-1",
            "name": "2020-2021-1"
        },
        {
            "value": "2019-2020-2",
            "name": "2019-2020-2"
        },
        {
            "value": "2019-2020-1",
            "name": "2019-2020-1"
        },
        {
            "value": "2018-2019-2",
            "name": "2018-2019-2"
        }
    ]
}
```

</details>

---

### 获取教学周历

方法：`calendar()`

所需参数：

| para     | type   | nullable | default | tips                     |
| -------- | ------ |:--------:| ------- | ------------------------ |
| semester | string | ❌        | ''      | 查询学年学期，默认值为空时自动获取取当前学期学年 |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$date = '202';
$list = $edusys->calendar($date);
echo json_encode($list);
```

返回参数：

<details>
    <summary>数据返回示例</summary>

```json
{
    "weeks": [
        {
            "title": "1",
            "remarks": "",
            "items": [
                "2022-08-29",
                "2022-08-30",
                "2022-08-31",
                "2022-09-01",
                "2022-09-02",
                "2022-09-03",
                "2022-09-04"
            ]
        },
        {
            "title": "2",
            "remarks": "",
            "items": [
                "2022-09-05",
                "2022-09-06",
                "2022-09-07",
                "2022-09-08",
                "2022-09-09",
                "2022-09-10",
                "2022-09-11"
            ]
        },
        {
            "title": "3",
            "remarks": "",
            "items": [
                "2022-09-12",
                "2022-09-13",
                "2022-09-14",
                "2022-09-15",
                "2022-09-16",
                "2022-09-17",
                "2022-09-18"
            ]
        },
        {
            "title": "4",
            "remarks": "",
            "items": [
                "2022-09-19",
                "2022-09-20",
                "2022-09-21",
                "2022-09-22",
                "2022-09-23",
                "2022-09-24",
                "2022-09-25"
            ]
        },
        {
            "title": "5",
            "remarks": "",
            "items": [
                "2022-09-26",
                "2022-09-27",
                "2022-09-28",
                "2022-09-29",
                "2022-09-30",
                "2022-10-01",
                "2022-10-02"
            ]
        },
        {
            "title": "6",
            "remarks": "",
            "items": [
                "2022-10-03",
                "2022-10-04",
                "2022-10-05",
                "2022-10-06",
                "2022-10-07",
                "2022-10-08",
                "2022-10-09"
            ]
        },
        {
            "title": "7",
            "remarks": "",
            "items": [
                "2022-10-10",
                "2022-10-11",
                "2022-10-12",
                "2022-10-13",
                "2022-10-14",
                "2022-10-15",
                "2022-10-16"
            ]
        },
        {
            "title": "8",
            "remarks": "",
            "items": [
                "2022-10-17",
                "2022-10-18",
                "2022-10-19",
                "2022-10-20",
                "2022-10-21",
                "2022-10-22",
                "2022-10-23"
            ]
        },
        {
            "title": "9",
            "remarks": "",
            "items": [
                "2022-10-24",
                "2022-10-25",
                "2022-10-26",
                "2022-10-27",
                "2022-10-28",
                "2022-10-29",
                "2022-10-30"
            ]
        },
        {
            "title": "10",
            "remarks": "",
            "items": [
                "2022-10-31",
                "2022-11-01",
                "2022-11-02",
                "2022-11-03",
                "2022-11-04",
                "2022-11-05",
                "2022-11-06"
            ]
        },
        {
            "title": "11",
            "remarks": "",
            "items": [
                "2022-11-07",
                "2022-11-08",
                "2022-11-09",
                "2022-11-10",
                "2022-11-11",
                "2022-11-12",
                "2022-11-13"
            ]
        },
        {
            "title": "12",
            "remarks": "",
            "items": [
                "2022-11-14",
                "2022-11-15",
                "2022-11-16",
                "2022-11-17",
                "2022-11-18",
                "2022-11-19",
                "2022-11-20"
            ]
        },
        {
            "title": "13",
            "remarks": "",
            "items": [
                "2022-11-21",
                "2022-11-22",
                "2022-11-23",
                "2022-11-24",
                "2022-11-25",
                "2022-11-26",
                "2022-11-27"
            ]
        },
        {
            "title": "14",
            "remarks": "",
            "items": [
                "2022-11-28",
                "2022-11-29",
                "2022-11-30",
                "2022-12-01",
                "2022-12-02",
                "2022-12-03",
                "2022-12-04"
            ]
        },
        {
            "title": "15",
            "remarks": "",
            "items": [
                "2022-12-05",
                "2022-12-06",
                "2022-12-07",
                "2022-12-08",
                "2022-12-09",
                "2022-12-10",
                "2022-12-11"
            ]
        },
        {
            "title": "16",
            "remarks": "",
            "items": [
                "2022-12-12",
                "2022-12-13",
                "2022-12-14",
                "2022-12-15",
                "2022-12-16",
                "2022-12-17",
                "2022-12-18"
            ]
        },
        {
            "title": "17",
            "remarks": "",
            "items": [
                "2022-12-19",
                "2022-12-20",
                "2022-12-21",
                "2022-12-22",
                "2022-12-23",
                "2022-12-24",
                "2022-12-25"
            ]
        },
        {
            "title": "18",
            "remarks": "",
            "items": [
                "2022-12-26",
                "2022-12-27",
                "2022-12-28",
                "2022-12-29",
                "2022-12-30",
                "2022-12-31",
                "2023-01-01"
            ]
        },
        {
            "title": "19",
            "remarks": "",
            "items": [
                "2023-01-02",
                "2023-01-03",
                "2023-01-04",
                "2023-01-05",
                "2023-01-06",
                "2023-01-07",
                "2023-01-08"
            ]
        },
        {
            "title": "20",
            "remarks": "",
            "items": [
                "2023-01-09",
                "2023-01-10",
                "2023-01-11",
                "2023-01-12",
                "2023-01-13",
                "2023-01-14",
                "2023-01-15"
            ]
        },
        {
            "title": "21",
            "remarks": "",
            "items": [
                "2023-01-16",
                "2023-01-17",
                "2023-01-18",
                "2023-01-19",
                "2023-01-20",
                "2023-01-21",
                "2023-01-22"
            ]
        },
        {
            "title": "22",
            "remarks": "",
            "items": [
                "2023-01-23",
                "2023-01-24",
                "2023-01-25",
                "2023-01-26",
                "2023-01-27",
                "2023-01-28",
                "2023-01-29"
            ]
        }
    ],
    "title": "2022-2023学年第1学期",
    "tips": "",
    "selected": {
        "value": "2022-2023-1",
        "name": "2022-2023-1"
    }
}
```

</details>

---

### 班级课表查询筛选项列表

方法：`classCourseOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->classCourseOptions();
echo json_encode($list);
```

<details>
    <summary>数据返回示例</summary>

```json
{
    "timeModel": [
        {
            "value": "9473F3E0DCAB413BE0535BDCFA0AFB99",
            "name": "默认节次模式",
            "checked": true
        }
    ],
    "semester": [
        {
            "value": "2022-2023-1",
            "name": "2022-2023-1",
            "checked": true
        },
        {
            "value": "2021-2022-2",
            "name": "2021-2022-2",
            "checked": false
        },
        {
            "value": "2021-2022-1",
            "name": "2021-2022-1",
            "checked": false
        },
        {
            "value": "2020-2021-2",
            "name": "2020-2021-2",
            "checked": false
        },
        {
            "value": "2020-2021-1",
            "name": "2020-2021-1",
            "checked": false
        },
        {
            "value": "2019-2020-2",
            "name": "2019-2020-2",
            "checked": false
        },
        {
            "value": "2019-2020-1",
            "name": "2019-2020-1",
            "checked": false
        },
        {
            "value": "2018-2019-2",
            "name": "2018-2019-2",
            "checked": false
        },
        {
            "value": "2018-2019-1",
            "name": "2018-2019-1",
            "checked": false
        },
        {
            "value": "2017-2018-2",
            "name": "2017-2018-2",
            "checked": false
        },
        {
            "value": "2017-2018-1",
            "name": "2017-2018-1",
            "checked": false
        },
        {
            "value": "2016-2017-3",
            "name": "2016-2017-3",
            "checked": false
        },
        {
            "value": "2016-2017-2",
            "name": "2016-2017-2",
            "checked": false
        },
        {
            "value": "2016-2017-1",
            "name": "2016-2017-1",
            "checked": false
        },
        {
            "value": "2015-2016-3",
            "name": "2015-2016-3",
            "checked": false
        },
        {
            "value": "2015-2016-2",
            "name": "2015-2016-2",
            "checked": false
        },
        {
            "value": "2015-2016-1",
            "name": "2015-2016-1",
            "checked": false
        },
        {
            "value": "2014-2015-3",
            "name": "2014-2015-3",
            "checked": false
        },
        {
            "value": "2014-2015-2",
            "name": "2014-2015-2",
            "checked": false
        },
        {
            "value": "2014-2015-1",
            "name": "2014-2015-1",
            "checked": false
        },
        {
            "value": "2013-2014-3",
            "name": "2013-2014-3",
            "checked": false
        },
        {
            "value": "2013-2014-2",
            "name": "2013-2014-2",
            "checked": false
        },
        {
            "value": "2013-2014-1",
            "name": "2013-2014-1",
            "checked": false
        },
        {
            "value": "2012-2013-3",
            "name": "2012-2013-3",
            "checked": false
        },
        {
            "value": "2012-2013-2",
            "name": "2012-2013-2",
            "checked": false
        },
        {
            "value": "2012-2013-1",
            "name": "2012-2013-1",
            "checked": false
        },
        {
            "value": "2011-2012-2",
            "name": "2011-2012-2",
            "checked": false
        },
        {
            "value": "2011-2012-1",
            "name": "2011-2012-1",
            "checked": false
        },
        {
            "value": "2010-2011-3",
            "name": "2010-2011-3",
            "checked": false
        },
        {
            "value": "2010-2011-2",
            "name": "2010-2011-2",
            "checked": false
        },
        {
            "value": "2010-2011-1",
            "name": "2010-2011-1",
            "checked": false
        },
        {
            "value": "2010-2011-0",
            "name": "2010-2011-0",
            "checked": false
        },
        {
            "value": "2009-2010-3",
            "name": "2009-2010-3",
            "checked": false
        },
        {
            "value": "2009-2010-2",
            "name": "2009-2010-2",
            "checked": false
        },
        {
            "value": "2009-2010-1",
            "name": "2009-2010-1",
            "checked": false
        },
        {
            "value": "2009-2010-0",
            "name": "2009-2010-0",
            "checked": false
        },
        {
            "value": "2008-2009-3",
            "name": "2008-2009-3",
            "checked": false
        },
        {
            "value": "2008-2009-2",
            "name": "2008-2009-2",
            "checked": false
        },
        {
            "value": "2008-2009-1",
            "name": "2008-2009-1",
            "checked": false
        },
        {
            "value": "2007-2008-3",
            "name": "2007-2008-3",
            "checked": false
        },
        {
            "value": "2007-2008-2",
            "name": "2007-2008-2",
            "checked": false
        },
        {
            "value": "2007-2008-1",
            "name": "2007-2008-1",
            "checked": false
        },
        {
            "value": "2006-2007-3",
            "name": "2006-2007-3",
            "checked": false
        },
        {
            "value": "2006-2007-2",
            "name": "2006-2007-2",
            "checked": false
        },
        {
            "value": "2006-2007-1",
            "name": "2006-2007-1",
            "checked": false
        },
        {
            "value": "2005-2006-2",
            "name": "2005-2006-2",
            "checked": false
        },
        {
            "value": "2005-2006-1",
            "name": "2005-2006-1",
            "checked": false
        },
        {
            "value": "2004-2005-2",
            "name": "2004-2005-2",
            "checked": false
        },
        {
            "value": "2004-2005-1",
            "name": "2004-2005-1",
            "checked": false
        },
        {
            "value": "2003-2004-2",
            "name": "2003-2004-2",
            "checked": false
        },
        {
            "value": "2003-2004-1",
            "name": "2003-2004-1",
            "checked": false
        },
        {
            "value": "2002-2003-2",
            "name": "2002-2003-2",
            "checked": false
        },
        {
            "value": "2002-2003-1",
            "name": "2002-2003-1",
            "checked": false
        },
        {
            "value": "2001-2002-2",
            "name": "2001-2002-2",
            "checked": false
        },
        {
            "value": "2001-2002-1",
            "name": "2001-2002-1",
            "checked": false
        },
        {
            "value": "2000-2001-2",
            "name": "2000-2001-2",
            "checked": false
        },
        {
            "value": "2000-2001-1",
            "name": "2000-2001-1",
            "checked": false
        }
    ],
    "grade": [
        {
            "value": "",
            "name": "-请选择-",
            "checked": true
        },
        {
            "value": "2022",
            "name": "2022",
            "checked": false
        },
        {
            "value": "2021",
            "name": "2021",
            "checked": false
        },
        {
            "value": "2020",
            "name": "2020",
            "checked": false
        },
        {
            "value": "2019",
            "name": "2019",
            "checked": false
        },
        {
            "value": "2018",
            "name": "2018",
            "checked": false
        },
        {
            "value": "2017",
            "name": "2017",
            "checked": false
        },
        {
            "value": "2016",
            "name": "2016",
            "checked": false
        },
        {
            "value": "2015",
            "name": "2015",
            "checked": false
        },
        {
            "value": "2014",
            "name": "2014",
            "checked": false
        },
        {
            "value": "2013",
            "name": "2013",
            "checked": false
        },
        {
            "value": "2012",
            "name": "2012",
            "checked": false
        },
        {
            "value": "2011",
            "name": "2011",
            "checked": false
        },
        {
            "value": "2010",
            "name": "2010",
            "checked": false
        },
        {
            "value": "2009",
            "name": "2009",
            "checked": false
        },
        {
            "value": "2008",
            "name": "2008",
            "checked": false
        },
        {
            "value": "2007",
            "name": "2007",
            "checked": false
        },
        {
            "value": "2006",
            "name": "2006",
            "checked": false
        },
        {
            "value": "2005",
            "name": "2005",
            "checked": false
        }
    ],
    "college": [
        {
            "value": "",
            "name": "-请选择-",
            "checked": true
        },
        {
            "value": "011",
            "name": "[011]土木工程系",
            "checked": false
        },
        {
            "value": "012",
            "name": "[012]环境工程系",
            "checked": false
        },
        {
            "value": "013",
            "name": "[013]艺术设计系",
            "checked": false
        },
        {
            "value": "02",
            "name": "[02]护理系",
            "checked": false
        },
        {
            "value": "1669097690654C2697E66260C1E678C9",
            "name": "[022]康复治疗系",
            "checked": false
        },
        {
            "value": "03",
            "name": "[03]材料科学与工程系",
            "checked": false
        },
        {
            "value": "04",
            "name": "[04]机械工程系",
            "checked": false
        },
        {
            "value": "F367CE0C4668477DA1F3D59B52D1AC43",
            "name": "[042]通信工程系",
            "checked": false
        },
        {
            "value": "DAD1F16577B44F8D9439402F4E8CEADB",
            "name": "[043]智能制造学院",
            "checked": false
        },
        {
            "value": "051",
            "name": "[051]信息工程系",
            "checked": false
        },
        {
            "value": "06",
            "name": "[06]音乐系",
            "checked": false
        },
        {
            "value": "FA5BD4515C4C4FA0987A6FC97C1F94E9",
            "name": "[062]舞蹈系",
            "checked": false
        },
        {
            "value": "071",
            "name": "[071]经济系",
            "checked": false
        },
        {
            "value": "08",
            "name": "[08]法律系",
            "checked": false
        },
        {
            "value": "09",
            "name": "[09]外语系",
            "checked": false
        },
        {
            "value": "091A1730BF0E4621BD53DEFED59D756A",
            "name": "[10]无人机系",
            "checked": false
        },
        {
            "value": "171",
            "name": "[171]管理系",
            "checked": false
        },
        {
            "value": "19E92A97E94D463587B72C954F33DAEF",
            "name": "[21]武装部",
            "checked": false
        },
        {
            "value": "27",
            "name": "[27]实验室管理中心",
            "checked": false
        },
        {
            "value": "547D47D5D53B4EB1AB09E6E551441C7E",
            "name": "[35]资产管理中心",
            "checked": false
        },
        {
            "value": "7BCD2332A8D04C108B01551417684BF9",
            "name": "[36]保卫处",
            "checked": false
        },
        {
            "value": "43",
            "name": "[43]体育部",
            "checked": false
        },
        {
            "value": "44",
            "name": "[44]思想政治部",
            "checked": false
        },
        {
            "value": "45",
            "name": "[45]公共教学部",
            "checked": false
        },
        {
            "value": "8D689F95650644F5B873356BFB248084",
            "name": "[46]劳动学院",
            "checked": false
        },
        {
            "value": "52",
            "name": "[52]基础部",
            "checked": false
        }
    ]
}
```

</details>

---

### 获取专业列表

获取专业列表

方法：`getProfessions()`

所需参数：

| para        | type   | nullable | default | tips                                      |
| ----------- | ------ |:--------:| ------- | ----------------------------------------- |
| collegeCode | string | ✅        | ''      | 院系代码（可从classCourseOptions()方法返回获取），空值获取全部 |
| grade       | string | ✅        | ''      | 年级（四位年份数字），空值获取全部                         |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->getProfessions();
echo json_encode($list);
```

<details>
    <summary>数据返回示例</summary>

```json
[
    {
        "dmmc": "土木工程",
        "dm": "0111"
    },
    {
        "dmmc": "土木工程(道路与桥梁工程)",
        "dm": "0113"
    },
    {
        "dmmc": "土木工程(建筑管理)",
        "dm": "0114"
    },
    {
        "dmmc": "工程造价",
        "dm": "0115"
    },
    {
        "dmmc": "土木工程(智能建筑)",
        "dm": "AE76EF2DF73142CD99DA0DF889AA384E"
    },
    {
        "dmmc": "环境工程",
        "dm": "0121"
    },
    {
        "dmmc": "视觉传达设计",
        "dm": "0131"
    },
    {
        "dmmc": "环境设计",
        "dm": "0132"
    },
    {
        "dmmc": "视觉传达设计(游戏视觉设计)",
        "dm": "CB1EB2F79B7F468FA9576C1758A5EA39"
    },
    {
        "dmmc": "护理学",
        "dm": "0211"
    },
    {
        "dmmc": "康复治疗学",
        "dm": "4336A30E39B642D6BB048213E8A03FD8"
    },
    {
        "dmmc": "材料科学与工程",
        "dm": "0311"
    },
    {
        "dmmc": "物流工程",
        "dm": "0411"
    },
    {
        "dmmc": "工业工程",
        "dm": "0412"
    },
    {
        "dmmc": "机械工程",
        "dm": "0413"
    },
    {
        "dmmc": "机械工程(机器人应用)",
        "dm": "0934995F08D74C32851893A0ADF1C918"
    },
    {
        "dmmc": "通信工程",
        "dm": "5C7F044F07EF400CBFDE15221CADFAB8"
    },
    {
        "dmmc": "自动化",
        "dm": "0B1F20BEF0FB49F080A6A0402DAB22EC"
    },
    {
        "dmmc": "自动化(智能制造)",
        "dm": "BF28BA4211E1491BBF8BD96EBBE6E733"
    },
    {
        "dmmc": "智能制造工程",
        "dm": "F42A275BE96848BBA29A5616C379295F"
    },
    {
        "dmmc": "通信工程",
        "dm": "0512"
    },
    {
        "dmmc": "电子信息工程",
        "dm": "0513"
    },
    {
        "dmmc": "信息与计算科学",
        "dm": "0514"
    },
    {
        "dmmc": "计算机科学与技术",
        "dm": "0515"
    },
    {
        "dmmc": "计算机科学与技术(软件技术)",
        "dm": "BAFB241CB5F44AC09CEF3F1339542B3B"
    },
    {
        "dmmc": "自动化",
        "dm": "0517"
    },
    {
        "dmmc": "计算机科学与技术（春）",
        "dm": "0518"
    },
    {
        "dmmc": "计算机科学与技术(智能技术)",
        "dm": "2E5C9338B5D14A7C9C94D724357E947D"
    },
    {
        "dmmc": "人工智能",
        "dm": "AC8FD8D04CB6453FA6FC2E3D109396DA"
    },
    {
        "dmmc": "音乐表演",
        "dm": "0611"
    },
    {
        "dmmc": "作曲与作曲技术理论",
        "dm": "0612"
    },
    {
        "dmmc": "舞蹈教育",
        "dm": "85B949445DCF44BAA844F458FC4B6427"
    },
    {
        "dmmc": "国际经济与贸易",
        "dm": "0711"
    },
    {
        "dmmc": "金融工程",
        "dm": "0712"
    },
    {
        "dmmc": "法学",
        "dm": "0811"
    },
    {
        "dmmc": "英语",
        "dm": "0911"
    },
    {
        "dmmc": "日语",
        "dm": "CC14356B04D246BA8892C01920CEDF64"
    },
    {
        "dmmc": "朝鲜语",
        "dm": "C79EA113524C4B8F9E2EAFAC6B7D5CE9"
    },
    {
        "dmmc": "无人驾驶航空器系统工程",
        "dm": "AB2154F399194BF1912FF53E3A264267"
    },
    {
        "dmmc": "无人驾驶航空器系统工程（春）",
        "dm": "C62DA9EFDAB647CEB135F1D51923C6D5"
    },
    {
        "dmmc": "会计学",
        "dm": "1711"
    },
    {
        "dmmc": "信息管理与信息系统",
        "dm": "1712"
    },
    {
        "dmmc": "财务管理",
        "dm": "1713"
    },
    {
        "dmmc": "会计学（春）",
        "dm": "1714"
    }
]
```

</details>

---

### 查询班级课表

方法：`classCourse()`

所修参数：

| para           | type   | nullable | default | tips                                   |
| -------------- | ------ |:--------:|:-------:| -------------------------------------- |
| semester       | string | ❌        | ❌       | 学年学期，不可为空，例2022-2023-1                 |
| timeModel      | string | ❌        | ❌       | 时间模式，请求[班级课表查询筛选项列表](#班级课表查询筛选项列表)接口获取 |
| college        | string | ✅        | ''      | 院系，请求[班级课表查询筛选项列表](#班级课表查询筛选项列表)接口获取   |
| grade          | string | ✅        | ''      | 年级（四位年份数字）                             |
| profession     | string | ✅        | ''      | 专业（专业代码）                               |
| className      | string | ✅        | ''      | 班级名称                                   |
| weekStart      | string | ✅        | ''      | 开始周（值1~30）                             |
| weekEnd        | string | ✅        | ''      | 结束周（值1~30）                             |
| dayOfWeekStart | string | ✅        | ''      | 开始星期几(值1~7)                            |
| dayOfWeekEnd   | string | ✅        | ''      | 结束星期几(值1~7)                            |
| serialNoStart  | string | ✅        | ''      | 开始节数                                   |
| serialNoEnd    | string | ✅        | ''      | 结束节数                                   |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$semester = '2022-2023-1';
$timeModel = $edusys->classCourseOptions()['timeModel'][0]['value'];
$college = '';
$grade = '2021';
$profession = '';
$className = '会计';
$list = $edusys->classCourse(
            $semester,
            $timeModel,
            $college,
            $grade,
            $profession,
            $className
        );
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    {
        "course": [
            {
                "title": "星期一",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "08:00",
                            "place": "9教204",
                            "endAt": "09:35",
                            "courseName": "刑法学II",
                            "className": "法学2101"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王超",
                            "startAt": "09:55",
                            "place": "9教301",
                            "endAt": "11:30",
                            "courseName": "民法学II",
                            "className": "法学2101"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "13:10",
                            "place": "9教102",
                            "endAt": "14:45",
                            "courseName": "刑法学II(O)",
                            "className": "法学2101"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "李文一",
                            "startAt": "16:50",
                            "place": "9教302",
                            "endAt": "18:25",
                            "courseName": "行政法与行政诉讼法II",
                            "className": "法学2101"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期二",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "08:00",
                            "place": "9教107",
                            "endAt": "09:35",
                            "courseName": "基础外语AIII",
                            "className": "法学2101"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "09:55",
                            "place": "9教203",
                            "endAt": "11:30",
                            "courseName": "商法学I",
                            "className": "法学2101"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王超",
                            "startAt": "15:00",
                            "place": "9教202",
                            "endAt": "16:35",
                            "courseName": "民法学II",
                            "className": "法学2101"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "16:50",
                            "place": "9教201",
                            "endAt": "18:25",
                            "courseName": "刑事诉讼法",
                            "className": "法学2101"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期三",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "史健",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III(31跆拳道)",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王清梅",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "孙昌辉",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王凯",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "陈富成",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘鹤伊",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "赵文男",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2101"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1,3-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "09:55",
                            "place": "8教106",
                            "endAt": "11:30",
                            "courseName": "商法学I",
                            "className": "法学2101"
                        }
                    ],
                    [],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "16:50",
                            "place": "9教201",
                            "endAt": "18:25",
                            "courseName": "刑事诉讼法(O)",
                            "className": "法学2101"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期四",
                "items": [
                    [],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "13:10",
                            "place": "9教207",
                            "endAt": "14:45",
                            "courseName": "基础外语AIII",
                            "className": "法学2101"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "7-10周",
                            "teacher": "李雲啸",
                            "startAt": "16:50",
                            "place": "9教103",
                            "endAt": "18:25",
                            "courseName": "大学生创新创业基础",
                            "className": "法学2101"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期五",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "张北根",
                            "startAt": "09:55",
                            "place": "8教102",
                            "endAt": "11:30",
                            "courseName": "毛泽东思想和中国特色社会主义理论体系概论I",
                            "className": "法学2101"
                        }
                    ],
                    [],
                    [],
                    [],
                    [
                        {
                            "teachWeek": "2周",
                            "teacher": "刘志苏",
                            "startAt": "19:10",
                            "place": "8教106",
                            "endAt": "21:35",
                            "courseName": "商法学I(P)",
                            "className": "法学2101"
                        }
                    ]
                ]
            },
            {
                "title": "星期六",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期日",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            }
        ],
        "className": "法学2101"
    },
    {
        "course": [
            {
                "title": "星期一",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "08:00",
                            "place": "9教204",
                            "endAt": "09:35",
                            "courseName": "刑法学II",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王超",
                            "startAt": "09:55",
                            "place": "9教301",
                            "endAt": "11:30",
                            "courseName": "民法学II",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "13:10",
                            "place": "9教102",
                            "endAt": "14:45",
                            "courseName": "刑法学II(O)",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘传海",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III(14健身)",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王凯",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "周盼盼",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘鹤伊",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "陈宇",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "孙昌辉",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘莉",
                            "startAt": "15:00",
                            "place": "",
                            "endAt": "16:35",
                            "courseName": "体育III",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "李文一",
                            "startAt": "16:50",
                            "place": "9教302",
                            "endAt": "18:25",
                            "courseName": "行政法与行政诉讼法II",
                            "className": "法学2102"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期二",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "08:00",
                            "place": "9教107",
                            "endAt": "09:35",
                            "courseName": "基础外语AIII",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "09:55",
                            "place": "9教203",
                            "endAt": "11:30",
                            "courseName": "商法学I",
                            "className": "法学2102"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王超",
                            "startAt": "15:00",
                            "place": "9教202",
                            "endAt": "16:35",
                            "courseName": "民法学II",
                            "className": "法学2102"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "16:50",
                            "place": "9教201",
                            "endAt": "18:25",
                            "courseName": "刑事诉讼法",
                            "className": "法学2102"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期三",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1,3-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "09:55",
                            "place": "8教106",
                            "endAt": "11:30",
                            "courseName": "商法学I",
                            "className": "法学2102"
                        }
                    ],
                    [],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "16:50",
                            "place": "9教201",
                            "endAt": "18:25",
                            "courseName": "刑事诉讼法(O)",
                            "className": "法学2102"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期四",
                "items": [
                    [],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "13:10",
                            "place": "9教207",
                            "endAt": "14:45",
                            "courseName": "基础外语AIII",
                            "className": "法学2102"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "7-10周",
                            "teacher": "李雲啸",
                            "startAt": "16:50",
                            "place": "9教103",
                            "endAt": "18:25",
                            "courseName": "大学生创新创业基础",
                            "className": "法学2102"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期五",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "张北根",
                            "startAt": "09:55",
                            "place": "8教102",
                            "endAt": "11:30",
                            "courseName": "毛泽东思想和中国特色社会主义理论体系概论I",
                            "className": "法学2102"
                        }
                    ],
                    [],
                    [],
                    [],
                    [
                        {
                            "teachWeek": "2周",
                            "teacher": "刘志苏",
                            "startAt": "19:10",
                            "place": "8教106",
                            "endAt": "21:35",
                            "courseName": "商法学I(P)",
                            "className": "法学2102"
                        }
                    ]
                ]
            },
            {
                "title": "星期六",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期日",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            }
        ],
        "className": "法学2102"
    },
    {
        "course": [
            {
                "title": "星期一",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王经",
                            "startAt": "08:00",
                            "place": "9教301",
                            "endAt": "09:35",
                            "courseName": "民法学II",
                            "className": "法学2103"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "09:55",
                            "place": "9教107",
                            "endAt": "11:30",
                            "courseName": "基础外语AIII",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "15:00",
                            "place": "9教204",
                            "endAt": "16:35",
                            "courseName": "刑法学II",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    []
                ]
            },
            {
                "title": "星期二",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "史健",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III(21跆拳道)",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "孙昌辉",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘传海",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "周盼盼",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "赵文男",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "陈宇",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "单佳",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "13:10",
                            "place": "9教102",
                            "endAt": "14:45",
                            "courseName": "刑法学II(O)",
                            "className": "法学2103"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "15:00",
                            "place": "9教201",
                            "endAt": "16:35",
                            "courseName": "刑事诉讼法",
                            "className": "法学2103"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "16:50",
                            "place": "9教203",
                            "endAt": "18:25",
                            "courseName": "商法学I",
                            "className": "法学2103"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期三",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "08:00",
                            "place": "9教106",
                            "endAt": "09:35",
                            "courseName": "基础外语AIII",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "13:10",
                            "place": "9教108",
                            "endAt": "14:45",
                            "courseName": "商法学I(O)",
                            "className": "法学2103"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "15:00",
                            "place": "9教201",
                            "endAt": "16:35",
                            "courseName": "刑事诉讼法(O)",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    []
                ]
            },
            {
                "title": "星期四",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王经",
                            "startAt": "09:55",
                            "place": "9教301",
                            "endAt": "11:30",
                            "courseName": "民法学II",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "李文一",
                            "startAt": "15:00",
                            "place": "9教203",
                            "endAt": "16:35",
                            "courseName": "行政法与行政诉讼法II",
                            "className": "法学2103"
                        }
                    ],
                    [
                        {
                            "teachWeek": "7-10周",
                            "teacher": "李雲啸",
                            "startAt": "16:50",
                            "place": "9教103",
                            "endAt": "18:25",
                            "courseName": "大学生创新创业基础",
                            "className": "法学2103"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期五",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "张北根",
                            "startAt": "09:55",
                            "place": "8教102",
                            "endAt": "11:30",
                            "courseName": "毛泽东思想和中国特色社会主义理论体系概论I",
                            "className": "法学2103"
                        }
                    ],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期六",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期日",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            }
        ],
        "className": "法学2103"
    },
    {
        "course": [
            {
                "title": "星期一",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王经",
                            "startAt": "08:00",
                            "place": "9教301",
                            "endAt": "09:35",
                            "courseName": "民法学II",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "09:55",
                            "place": "9教107",
                            "endAt": "11:30",
                            "courseName": "基础外语AIII",
                            "className": "法学2104"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "15:00",
                            "place": "9教204",
                            "endAt": "16:35",
                            "courseName": "刑法学II",
                            "className": "法学2104"
                        }
                    ],
                    [],
                    []
                ]
            },
            {
                "title": "星期二",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "陈宇",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III(21游泳)",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "赵文男",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "周盼盼",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "孙昌辉",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘传海",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "单佳",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        },
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "史健",
                            "startAt": "08:00",
                            "place": "",
                            "endAt": "09:35",
                            "courseName": "体育III",
                            "className": "法学2104"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘书祥",
                            "startAt": "13:10",
                            "place": "9教102",
                            "endAt": "14:45",
                            "courseName": "刑法学II(O)",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "15:00",
                            "place": "9教201",
                            "endAt": "16:35",
                            "courseName": "刑事诉讼法",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "16:50",
                            "place": "9教203",
                            "endAt": "18:25",
                            "courseName": "商法学I",
                            "className": "法学2104"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期三",
                "items": [
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "于飞",
                            "startAt": "08:00",
                            "place": "9教106",
                            "endAt": "09:35",
                            "courseName": "基础外语AIII",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "郭敏",
                            "startAt": "09:55",
                            "place": "8教102",
                            "endAt": "11:30",
                            "courseName": "毛泽东思想和中国特色社会主义理论体系概论I",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘志苏",
                            "startAt": "13:10",
                            "place": "9教108",
                            "endAt": "14:45",
                            "courseName": "商法学I(O)",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "刘国平",
                            "startAt": "15:00",
                            "place": "9教201",
                            "endAt": "16:35",
                            "courseName": "刑事诉讼法(O)",
                            "className": "法学2104"
                        }
                    ],
                    [],
                    []
                ]
            },
            {
                "title": "星期四",
                "items": [
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "王经",
                            "startAt": "09:55",
                            "place": "9教301",
                            "endAt": "11:30",
                            "courseName": "民法学II",
                            "className": "法学2104"
                        }
                    ],
                    [],
                    [
                        {
                            "teachWeek": "1-5,7-17周",
                            "teacher": "李文一",
                            "startAt": "15:00",
                            "place": "9教203",
                            "endAt": "16:35",
                            "courseName": "行政法与行政诉讼法II",
                            "className": "法学2104"
                        }
                    ],
                    [
                        {
                            "teachWeek": "7-10周",
                            "teacher": "李雲啸",
                            "startAt": "16:50",
                            "place": "9教103",
                            "endAt": "18:25",
                            "courseName": "大学生创新创业基础",
                            "className": "法学2104"
                        }
                    ],
                    []
                ]
            },
            {
                "title": "星期五",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期六",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            },
            {
                "title": "星期日",
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ]
            }
        ],
        "className": "法学2104"
    }
]
```

</details>

---

### 教师课表查询筛选项列表

方法：`teacherCourseOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->teacherCourseOptions();
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
{
    "timeModel": [
        {
            "value": "9473F3E0DCAB413BE0535BDCFA0AFB99",
            "name": "默认节次模式",
            "checked": true
        }
    ],
    "semester": [
        {
            "value": "2022-2023-1",
            "name": "2022-2023-1",
            "checked": true
        },
        {
            "value": "2021-2022-2",
            "name": "2021-2022-2",
            "checked": false
        },
        {
            "value": "2021-2022-1",
            "name": "2021-2022-1",
            "checked": false
        },
        {
            "value": "2020-2021-2",
            "name": "2020-2021-2",
            "checked": false
        },
        {
            "value": "2020-2021-1",
            "name": "2020-2021-1",
            "checked": false
        },
        {
            "value": "2019-2020-2",
            "name": "2019-2020-2",
            "checked": false
        },
        {
            "value": "2019-2020-1",
            "name": "2019-2020-1",
            "checked": false
        },
        {
            "value": "2018-2019-2",
            "name": "2018-2019-2",
            "checked": false
        },
        {
            "value": "2018-2019-1",
            "name": "2018-2019-1",
            "checked": false
        },
        {
            "value": "2017-2018-2",
            "name": "2017-2018-2",
            "checked": false
        },
        {
            "value": "2017-2018-1",
            "name": "2017-2018-1",
            "checked": false
        },
        {
            "value": "2016-2017-3",
            "name": "2016-2017-3",
            "checked": false
        },
        {
            "value": "2016-2017-2",
            "name": "2016-2017-2",
            "checked": false
        },
        {
            "value": "2016-2017-1",
            "name": "2016-2017-1",
            "checked": false
        },
        {
            "value": "2015-2016-3",
            "name": "2015-2016-3",
            "checked": false
        },
        {
            "value": "2015-2016-2",
            "name": "2015-2016-2",
            "checked": false
        },
        {
            "value": "2015-2016-1",
            "name": "2015-2016-1",
            "checked": false
        },
        {
            "value": "2014-2015-3",
            "name": "2014-2015-3",
            "checked": false
        },
        {
            "value": "2014-2015-2",
            "name": "2014-2015-2",
            "checked": false
        },
        {
            "value": "2014-2015-1",
            "name": "2014-2015-1",
            "checked": false
        },
        {
            "value": "2013-2014-3",
            "name": "2013-2014-3",
            "checked": false
        },
        {
            "value": "2013-2014-2",
            "name": "2013-2014-2",
            "checked": false
        },
        {
            "value": "2013-2014-1",
            "name": "2013-2014-1",
            "checked": false
        },
        {
            "value": "2012-2013-3",
            "name": "2012-2013-3",
            "checked": false
        },
        {
            "value": "2012-2013-2",
            "name": "2012-2013-2",
            "checked": false
        },
        {
            "value": "2012-2013-1",
            "name": "2012-2013-1",
            "checked": false
        },
        {
            "value": "2011-2012-2",
            "name": "2011-2012-2",
            "checked": false
        },
        {
            "value": "2011-2012-1",
            "name": "2011-2012-1",
            "checked": false
        },
        {
            "value": "2010-2011-3",
            "name": "2010-2011-3",
            "checked": false
        },
        {
            "value": "2010-2011-2",
            "name": "2010-2011-2",
            "checked": false
        },
        {
            "value": "2010-2011-1",
            "name": "2010-2011-1",
            "checked": false
        },
        {
            "value": "2010-2011-0",
            "name": "2010-2011-0",
            "checked": false
        },
        {
            "value": "2009-2010-3",
            "name": "2009-2010-3",
            "checked": false
        },
        {
            "value": "2009-2010-2",
            "name": "2009-2010-2",
            "checked": false
        },
        {
            "value": "2009-2010-1",
            "name": "2009-2010-1",
            "checked": false
        },
        {
            "value": "2009-2010-0",
            "name": "2009-2010-0",
            "checked": false
        },
        {
            "value": "2008-2009-3",
            "name": "2008-2009-3",
            "checked": false
        },
        {
            "value": "2008-2009-2",
            "name": "2008-2009-2",
            "checked": false
        },
        {
            "value": "2008-2009-1",
            "name": "2008-2009-1",
            "checked": false
        },
        {
            "value": "2007-2008-3",
            "name": "2007-2008-3",
            "checked": false
        },
        {
            "value": "2007-2008-2",
            "name": "2007-2008-2",
            "checked": false
        },
        {
            "value": "2007-2008-1",
            "name": "2007-2008-1",
            "checked": false
        },
        {
            "value": "2006-2007-3",
            "name": "2006-2007-3",
            "checked": false
        },
        {
            "value": "2006-2007-2",
            "name": "2006-2007-2",
            "checked": false
        },
        {
            "value": "2006-2007-1",
            "name": "2006-2007-1",
            "checked": false
        },
        {
            "value": "2005-2006-2",
            "name": "2005-2006-2",
            "checked": false
        },
        {
            "value": "2005-2006-1",
            "name": "2005-2006-1",
            "checked": false
        },
        {
            "value": "2004-2005-2",
            "name": "2004-2005-2",
            "checked": false
        },
        {
            "value": "2004-2005-1",
            "name": "2004-2005-1",
            "checked": false
        },
        {
            "value": "2003-2004-2",
            "name": "2003-2004-2",
            "checked": false
        },
        {
            "value": "2003-2004-1",
            "name": "2003-2004-1",
            "checked": false
        },
        {
            "value": "2002-2003-2",
            "name": "2002-2003-2",
            "checked": false
        },
        {
            "value": "2002-2003-1",
            "name": "2002-2003-1",
            "checked": false
        },
        {
            "value": "2001-2002-2",
            "name": "2001-2002-2",
            "checked": false
        },
        {
            "value": "2001-2002-1",
            "name": "2001-2002-1",
            "checked": false
        },
        {
            "value": "2000-2001-2",
            "name": "2000-2001-2",
            "checked": false
        },
        {
            "value": "2000-2001-1",
            "name": "2000-2001-1",
            "checked": false
        }
    ],
    "college": [
        {
            "value": "",
            "name": "-请选择-",
            "checked": true
        },
        {
            "value": "011",
            "name": "[011]土木工程系",
            "checked": false
        },
        {
            "value": "012",
            "name": "[012]环境工程系",
            "checked": false
        },
        {
            "value": "013",
            "name": "[013]艺术设计系",
            "checked": false
        },
        {
            "value": "02",
            "name": "[02]护理系",
            "checked": false
        },
        {
            "value": "1669097690654C2697E66260C1E678C9",
            "name": "[022]康复治疗系",
            "checked": false
        },
        {
            "value": "03",
            "name": "[03]材料科学与工程系",
            "checked": false
        },
        {
            "value": "04",
            "name": "[04]机械工程系",
            "checked": false
        },
        {
            "value": "F367CE0C4668477DA1F3D59B52D1AC43",
            "name": "[042]通信工程系",
            "checked": false
        },
        {
            "value": "DAD1F16577B44F8D9439402F4E8CEADB",
            "name": "[043]智能制造学院",
            "checked": false
        },
        {
            "value": "051",
            "name": "[051]信息工程系",
            "checked": false
        },
        {
            "value": "06",
            "name": "[06]音乐系",
            "checked": false
        },
        {
            "value": "FA5BD4515C4C4FA0987A6FC97C1F94E9",
            "name": "[062]舞蹈系",
            "checked": false
        },
        {
            "value": "071",
            "name": "[071]经济系",
            "checked": false
        },
        {
            "value": "08",
            "name": "[08]法律系",
            "checked": false
        },
        {
            "value": "09",
            "name": "[09]外语系",
            "checked": false
        },
        {
            "value": "091A1730BF0E4621BD53DEFED59D756A",
            "name": "[10]无人机系",
            "checked": false
        },
        {
            "value": "171",
            "name": "[171]管理系",
            "checked": false
        },
        {
            "value": "19E92A97E94D463587B72C954F33DAEF",
            "name": "[21]武装部",
            "checked": false
        },
        {
            "value": "27",
            "name": "[27]实验室管理中心",
            "checked": false
        },
        {
            "value": "547D47D5D53B4EB1AB09E6E551441C7E",
            "name": "[35]资产管理中心",
            "checked": false
        },
        {
            "value": "7BCD2332A8D04C108B01551417684BF9",
            "name": "[36]保卫处",
            "checked": false
        },
        {
            "value": "43",
            "name": "[43]体育部",
            "checked": false
        },
        {
            "value": "44",
            "name": "[44]思想政治部",
            "checked": false
        },
        {
            "value": "45",
            "name": "[45]公共教学部",
            "checked": false
        },
        {
            "value": "8D689F95650644F5B873356BFB248084",
            "name": "[46]劳动学院",
            "checked": false
        },
        {
            "value": "52",
            "name": "[52]基础部",
            "checked": false
        }
    ]
}
```

</details>

 ---

### 查询教师课表

> 部分上课班级信息与课程名称混在一起，难以分离，因此返回信息暂不返回上课班级名称

 方法：`teacherCourse()`

所需参数：

| para           | type   | nullable | default | tips                                   |
| -------------- | ------ |:--------:|:-------:| -------------------------------------- |
| semester       | string | ❌        | ❌       | 学年学期，不可为空，例2022-2023-1                 |
| timeModel      | string | ❌        | ❌       | 时间模式，请求[教师课表查询筛选项列表](#教师课表查询筛选项列表)接口获取 |
| college        | string | ✅        | ''      | 院系，请求[教师课表查询筛选项列表](#教师课表查询筛选项列表)接口获取   |
| teacherLevel   | string | ✅        | ''      | 教师职称（系统隐藏未使用，保持空值即可）                   |
| teacherName    | string | ✅        | ''      | 教师姓名                                   |
| weekStart      | string | ✅        | ''      | 开始周（值1~30）                             |
| weekEnd        | string | ✅        | ''      | 结束周（值1~30）                             |
| dayOfWeekStart | string | ✅        | ''      | 开始星期几(值1~7)                            |
| dayOfWeekEnd   | string | ✅        | ''      | 结束星期几(值1~7)                            |
| serialNoStart  | string | ✅        | ''      | 开始节数                                   |
| serialNoEnd    | string | ✅        | ''      | 结束节数                                   |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$semester = '2022-2023-1';
$timeModel = $edusys->teacherCourseOptions()['timeModel'][0]['value'];
$college = '';
$teacherLevel = '';
$teacherName = '张';
$list = $edusys->teacherCourse(
            $semester,
            $timeModel,
            $college,
            $teacherLevel,
            $teacherName,
            ‘’,
            ‘’,
            ‘’,
            '',
            '',
            ''
        );
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
  {
    "teacherName": "张北根",
    "course": [
      {
        "title": "星期一",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期二",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期三",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期四",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期五",
        "items": [
          [
            {
              "teachWeek": "1-5,7-17周",
              "teacher": "张北根",
              "startAt": "08:00",
              "place": "8教102",
              "endAt": "09:35",
              "courseName": "毛泽东思想和中国特色社会主义理论体系概论I计2101-3"
            }
          ],
          [
            {
              "teachWeek": "1-5,7-17周",
              "teacher": "张北根",
              "startAt": "09:55",
              "place": "8教102",
              "endAt": "11:30",
              "courseName": "毛泽东思想和中国特色社会主义理论体系概论I法学2101-3"
            }
          ],
          [
            {
              "teachWeek": "1-5,7-17周",
              "teacher": "张北根",
              "startAt": "13:10",
              "place": "8教102",
              "endAt": "14:45",
              "courseName": "毛泽东思想和中国特色社会主义理论体系概论I计智2101-3"
            }
          ],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期六",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期日",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      }
    ]
  },
  {
    "teacherName": "张伟",
    "course": [
      {
        "title": "星期一",
        "items": [
          [],
          [
            {
              "teachWeek": "2-5,7-17周",
              "teacher": "张伟",
              "startAt": "09:55",
              "place": "10教303",
              "endAt": "11:30",
              "courseName": "程序设计基础I计[2211-2212]班"
            }
          ],
          [
            {
              "teachWeek": "1-5,7-17周",
              "teacher": "张伟",
              "startAt": "13:10",
              "place": "10教303",
              "endAt": "14:45",
              "courseName": "Linux操作系统计[2005-2006]班"
            }
          ],
          [],
          [
            {
              "teachWeek": "1-5,7-13周",
              "teacher": "张伟",
              "startAt": "16:50",
              "place": "9教307",
              "endAt": "18:25",
              "courseName": "Java面向对象程序设计通信[2101-2102]班"
            }
          ],
          []
        ]
      },
      {
        "title": "星期二",
        "items": [
          [],
          [],
          [],
          [],
          [
            {
              "teachWeek": "2-5,7-14周",
              "teacher": "张伟",
              "startAt": "16:50",
              "place": "10教301",
              "endAt": "18:25",
              "courseName": "Java面向对象程序设计通信[2101-2102]班"
            }
          ],
          []
        ]
      },
      {
        "title": "星期三",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期四",
        "items": [
          [],
          [],
          [
            {
              "teachWeek": "1-5,7-17周",
              "teacher": "张伟",
              "startAt": "13:10",
              "place": "10教303",
              "endAt": "14:45",
              "courseName": "Linux操作系统计[2003-2004]班"
            }
          ],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期五",
        "items": [
          [
            {
              "teachWeek": "1-5,7-9周",
              "teacher": "张伟",
              "startAt": "08:00",
              "place": "3教410",
              "endAt": "09:35",
              "courseName": "Python高级应用无人机[2001-2004]班"
            }
          ],
          [
            {
              "teachWeek": "1-5,7-9周",
              "teacher": "张伟",
              "startAt": "09:55",
              "place": "3教410",
              "endAt": "11:30",
              "courseName": "Python高级应用无人机[2001-2004]班"
            }
          ],
          [],
          [
            {
              "teachWeek": "1-5,7-9周",
              "teacher": "张伟",
              "startAt": "15:00",
              "place": "3教410",
              "endAt": "16:35",
              "courseName": "Python高级应用计[2004-2008]班"
            }
          ],
          [
            {
              "teachWeek": "1-5,7-9周",
              "teacher": "张伟",
              "startAt": "16:50",
              "place": "3教410",
              "endAt": "18:25",
              "courseName": "Python高级应用计[2004-2008]班"
            }
          ],
          []
        ]
      },
      {
        "title": "星期六",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      },
      {
        "title": "星期日",
        "items": [
          [],
          [],
          [],
          [],
          [],
          []
        ]
      }
    ]
  }
]
```

</details>

### 课程课表查询筛选项列表

方法：`lessonCourseOptions()`

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$list = $edusys->lessonCourseOptions();
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
        },
        {
            "name": "2021-2022-2",
            "value": "2021-2022-2",
            "checked": false
        },
        {
            "name": "2021-2022-1",
            "value": "2021-2022-1",
            "checked": false
        },
        {
            "name": "2020-2021-2",
            "value": "2020-2021-2",
            "checked": false
        },
        {
            "name": "2020-2021-1",
            "value": "2020-2021-1",
            "checked": false
        },
        {
            "name": "2019-2020-2",
            "value": "2019-2020-2",
            "checked": false
        },
        {
            "name": "2019-2020-1",
            "value": "2019-2020-1",
            "checked": false
        },
        {
            "name": "2018-2019-2",
            "value": "2018-2019-2",
            "checked": false
        },
        {
            "name": "2018-2019-1",
            "value": "2018-2019-1",
            "checked": false
        },
        {
            "name": "2017-2018-2",
            "value": "2017-2018-2",
            "checked": false
        },
        {
            "name": "2017-2018-1",
            "value": "2017-2018-1",
            "checked": false
        },
        {
            "name": "2016-2017-3",
            "value": "2016-2017-3",
            "checked": false
        },
        {
            "name": "2016-2017-2",
            "value": "2016-2017-2",
            "checked": false
        },
        {
            "name": "2016-2017-1",
            "value": "2016-2017-1",
            "checked": false
        },
        {
            "name": "2015-2016-3",
            "value": "2015-2016-3",
            "checked": false
        },
        {
            "name": "2015-2016-2",
            "value": "2015-2016-2",
            "checked": false
        },
        {
            "name": "2015-2016-1",
            "value": "2015-2016-1",
            "checked": false
        },
        {
            "name": "2014-2015-3",
            "value": "2014-2015-3",
            "checked": false
        },
        {
            "name": "2014-2015-2",
            "value": "2014-2015-2",
            "checked": false
        },
        {
            "name": "2014-2015-1",
            "value": "2014-2015-1",
            "checked": false
        },
        {
            "name": "2013-2014-3",
            "value": "2013-2014-3",
            "checked": false
        },
        {
            "name": "2013-2014-2",
            "value": "2013-2014-2",
            "checked": false
        },
        {
            "name": "2013-2014-1",
            "value": "2013-2014-1",
            "checked": false
        },
        {
            "name": "2012-2013-3",
            "value": "2012-2013-3",
            "checked": false
        },
        {
            "name": "2012-2013-2",
            "value": "2012-2013-2",
            "checked": false
        },
        {
            "name": "2012-2013-1",
            "value": "2012-2013-1",
            "checked": false
        },
        {
            "name": "2011-2012-2",
            "value": "2011-2012-2",
            "checked": false
        },
        {
            "name": "2011-2012-1",
            "value": "2011-2012-1",
            "checked": false
        },
        {
            "name": "2010-2011-3",
            "value": "2010-2011-3",
            "checked": false
        },
        {
            "name": "2010-2011-2",
            "value": "2010-2011-2",
            "checked": false
        },
        {
            "name": "2010-2011-1",
            "value": "2010-2011-1",
            "checked": false
        },
        {
            "name": "2010-2011-0",
            "value": "2010-2011-0",
            "checked": false
        },
        {
            "name": "2009-2010-3",
            "value": "2009-2010-3",
            "checked": false
        },
        {
            "name": "2009-2010-2",
            "value": "2009-2010-2",
            "checked": false
        },
        {
            "name": "2009-2010-1",
            "value": "2009-2010-1",
            "checked": false
        },
        {
            "name": "2009-2010-0",
            "value": "2009-2010-0",
            "checked": false
        },
        {
            "name": "2008-2009-3",
            "value": "2008-2009-3",
            "checked": false
        },
        {
            "name": "2008-2009-2",
            "value": "2008-2009-2",
            "checked": false
        },
        {
            "name": "2008-2009-1",
            "value": "2008-2009-1",
            "checked": false
        },
        {
            "name": "2007-2008-3",
            "value": "2007-2008-3",
            "checked": false
        },
        {
            "name": "2007-2008-2",
            "value": "2007-2008-2",
            "checked": false
        },
        {
            "name": "2007-2008-1",
            "value": "2007-2008-1",
            "checked": false
        },
        {
            "name": "2006-2007-3",
            "value": "2006-2007-3",
            "checked": false
        },
        {
            "name": "2006-2007-2",
            "value": "2006-2007-2",
            "checked": false
        },
        {
            "name": "2006-2007-1",
            "value": "2006-2007-1",
            "checked": false
        },
        {
            "name": "2005-2006-2",
            "value": "2005-2006-2",
            "checked": false
        },
        {
            "name": "2005-2006-1",
            "value": "2005-2006-1",
            "checked": false
        },
        {
            "name": "2004-2005-2",
            "value": "2004-2005-2",
            "checked": false
        },
        {
            "name": "2004-2005-1",
            "value": "2004-2005-1",
            "checked": false
        },
        {
            "name": "2003-2004-2",
            "value": "2003-2004-2",
            "checked": false
        },
        {
            "name": "2003-2004-1",
            "value": "2003-2004-1",
            "checked": false
        },
        {
            "name": "2002-2003-2",
            "value": "2002-2003-2",
            "checked": false
        },
        {
            "name": "2002-2003-1",
            "value": "2002-2003-1",
            "checked": false
        },
        {
            "name": "2001-2002-2",
            "value": "2001-2002-2",
            "checked": false
        },
        {
            "name": "2001-2002-1",
            "value": "2001-2002-1",
            "checked": false
        },
        {
            "name": "2000-2001-2",
            "value": "2000-2001-2",
            "checked": false
        },
        {
            "name": "2000-2001-1",
            "value": "2000-2001-1",
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
    "studyCollege": [
        {
            "name": "-请选择-",
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
    "teachCollege": [
        {
            "name": "-请选择-",
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
            "name": "[33]国际交流处",
            "value": "33",
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
    "courseNature": [
        {
            "name": "-请选择-",
            "value": "",
            "checked": true
        },
        {
            "name": "必修",
            "value": "1",
            "checked": false
        },
        {
            "name": "限选",
            "value": "2",
            "checked": false
        },
        {
            "name": "公选",
            "value": "4",
            "checked": false
        },
        {
            "name": "专选（必选）",
            "value": "5",
            "checked": false
        },
        {
            "name": "专选（自选）",
            "value": "6",
            "checked": false
        },
        {
            "name": "其它",
            "value": "9",
            "checked": false
        }
    ]
}
```

</details>

---

### 查询课程课表

> 部分上课班级信息与课程名称混在一起，难以分离，因此返回信息暂不返回上课班级名称

方法：`lessonCourse()`

所需参数：

| para           | type   | nullable | default | tips                                   |
| -------------- | ------ | -------- | ------- | -------------------------------------- |
| semester       | string | ❌        | ❌       | 学年学期，不可为空，例2022-2023-1                 |
| timeModel      | string | ❌        | ❌       | 时间模式，请求[课程课表查询筛选项列表](#课程课表查询筛选项列表)接口获取 |
| studyCollege   | string | ✅        | ''      | 院系，请求[课程课表查询筛选项列表](#课程课表查询筛选项列表)接口获取   |
| teachCollege   | string | ✅        | ''      | 开课院系，请求[课程课表查询筛选项列表](#课程课表查询筛选项列表)接口获取 |
| courseNature   | string | ✅        | ''      | 课程属性，请求[课程课表查询筛选项列表](#课程课表查询筛选项列表)接口获取 |
| courseName     | string | ✅        | ''      | 课程名称                                   |
| weekStart      | string | ✅        | ''      | 开始周（值1~30）                             |
| weekEnd        | string | ✅        | ''      | 结束周（值1~30）                             |
| dayOfWeekStart | string | ✅        | ''      | 开始星期几(值1~7)                            |
| dayOfWeekEnd   | string | ✅        | ''      | 结束星期几(值1~7)                            |
| serialNoStart  | string | ✅        | ''      | 开始节数                                   |
| serialNoEnd    | string | ✅        | ''      | 结束节数                                   |

调用示例：

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$semester = '2022-2023-1';
$timeModel = $edusys->lessonCourseOptions()['timeModel'][0]['value'];
$courseName = '大学语文';
$list = $edusys->lessonCourse(
            $semester,
            $timeModel,
            '',
            '',
            '',
            $courseName,
            ‘’,
            ‘’,
            ‘’,
            '',
            '',
            ''
        );
echo json_encode($list);
```

<details>
  <summary>返回参数示例</summary>

```json
[
    {
        "courseName": "大学日语II",
        "course": [
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期一"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期二"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [
                        {
                            "courseName": "大学日语II",
                            "teacher": "孟彤",
                            "teachWeek": "1-16周",
                            "place": "9教205",
                            "classnames": "临班1",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        },
                        {
                            "courseName": "大学日语II",
                            "teacher": "卢是之",
                            "teachWeek": "1-16周",
                            "place": "9教206",
                            "classnames": "临班5",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        }
                    ],
                    [
                        {
                            "courseName": "大学日语II",
                            "teacher": "孟彤",
                            "teachWeek": "1-16周",
                            "place": "9教205",
                            "classnames": "临班1",
                            "startAt": "19:10",
                            "endAt": "21:35"
                        },
                        {
                            "courseName": "大学日语II",
                            "teacher": "卢是之",
                            "teachWeek": "1-16周",
                            "place": "9教206",
                            "classnames": "临班5",
                            "startAt": "19:10",
                            "endAt": "21:35"
                        }
                    ]
                ],
                "title": "星期三"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期四"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [
                        {
                            "courseName": "大学日语II",
                            "teacher": "田军",
                            "teachWeek": "1-16周",
                            "place": "9教205",
                            "classnames": "临班3",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        },
                        {
                            "courseName": "大学日语II",
                            "teacher": "卢是之",
                            "teachWeek": "1-16周",
                            "place": "9教206",
                            "classnames": "临班7",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        }
                    ],
                    [
                        {
                            "courseName": "大学日语II",
                            "teacher": "田军",
                            "teachWeek": "1-16周",
                            "place": "9教205",
                            "classnames": "临班3",
                            "startAt": "19:10",
                            "endAt": "21:35"
                        },
                        {
                            "courseName": "大学日语II",
                            "teacher": "卢是之",
                            "teachWeek": "1-16周",
                            "place": "9教206",
                            "classnames": "临班7",
                            "startAt": "19:10",
                            "endAt": "21:35"
                        }
                    ]
                ],
                "title": "星期五"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期六"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期日"
            }
        ]
    },
    {
        "courseName": "大学日语IV",
        "course": [
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期一"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期二"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [
                        {
                            "courseName": "大学日语IV",
                            "teacher": "董玲",
                            "teachWeek": "1-16周",
                            "place": "8教205",
                            "classnames": "临班9",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        },
                        {
                            "courseName": "大学日语IV",
                            "teacher": "胡贝贝",
                            "teachWeek": "1-16周",
                            "place": "8教206",
                            "classnames": "临班11",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        },
                        {
                            "courseName": "大学日语IV",
                            "teacher": "黄静",
                            "teachWeek": "1-16周",
                            "place": "8教207",
                            "classnames": "临班13",
                            "startAt": "16:50",
                            "endAt": "18:25"
                        }
                    ],
                    []
                ],
                "title": "星期三"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期四"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期五"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期六"
            },
            {
                "items": [
                    [],
                    [],
                    [],
                    [],
                    [],
                    []
                ],
                "title": "星期日"
            }
        ]
    }
]
```

</details>

---
