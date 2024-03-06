<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 教室相关
 */
class Classroom extends Base
{
    /**
     * 初始化
     * @throws Exception
     */
    public function __construct(string $usercode = '', string $cookie = '')
    {
        parent::__construct();
        $this->cookie = $cookie;
        $this->usercode = $usercode;
        if (empty($this->cookie)) throw new Exception('cookie不得为空');
        if (empty($this->usercode)) throw new Exception('学号参数不得为空');
    }

    /**
     * 教室借用情况筛选项
     * @return array
     * @throws Exception
     */
    public function options(): array
    {
        $referer = $this->edusysUrl . ($this->isStudent($this->usercode) ? '/jsxsd/framework/xsMain.jsp' : '/jsxsd/framework/jsMain.jsp');
        $html = $this->httpGet('/jsxsd/kbxx/jsjy_query', $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatOptions($html['data']);
    }

    /**
     * 解析匹配格式化教室借用情况筛选项
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatOptions(string $html): array
    {
        // 学期学年
        preg_match('/name="xnxqh" value ="(.*?)"\/>/', $html, $semester);
        $semester = $semester ? $semester[1] : '';
        $semester = [
            ['name' => $semester, 'value' => $semester, 'checked' => true]
        ];

        // 校区
        preg_match('/校区.*?教学区/s', $html, $schoolAreaHtml);
        $schoolAreaHtml = $schoolAreaHtml ? $schoolAreaHtml[0] : '';
        $schoolAreaOptions = $this->formatOption($schoolAreaHtml, '/<option.*?>(.*?)<\/option>/', '/<option value="(.*)?"/');

        // 教学区
        preg_match('/教学区.*?教室类型/s', $html, $teachAreaHtml);
        $teachAreaHtml = $teachAreaHtml ? $teachAreaHtml[0] : '';
        $teachAreaOptions = $this->formatOption($teachAreaHtml, '/<option value="">(.*?)<\/option>/', '/<option value="(.*)?"/');

        // 教室类型
        preg_match('/教室类型.*?教学楼/s', $html, $classroomTypeHtml);
        $classroomTypeHtml = $classroomTypeHtml ? $classroomTypeHtml[0] : '';
        $classroomTypeOptions = $this->formatOption($classroomTypeHtml, '', '/<option value="(.*)?"/');

        // 教学楼
        // $building = $this->classroomList('building');
        // 教室
        // $classroom = $this->classroomList('classroom');

        // 容纳人数比较符号
        preg_match('/人数.*?教室状态/s', $html, $peopleSignHtml);
        $peopleSignHtml = $peopleSignHtml ? $peopleSignHtml[0] : '';
        $peopleSignOptions = $this->formatOption($peopleSignHtml, '/<option.*?>(.*?)<\/option>/s', '/<option value="(.*)?"/');
        foreach ($peopleSignOptions as $index => $item) {
            $peopleSignOptions[$index]['name'] = html_entity_decode($this->stripBlankspace($item['name']));
        }

        // 教室状态
        preg_match('/教室状态.*?借用院系/s', $html, $classroomStatusHtml);
        $classroomStatusHtml = $classroomStatusHtml ? $classroomStatusHtml[0] : '';
        $classroomStatusOptions = $this->formatOption($classroomStatusHtml, '/<option.*?>(.*?)<\/option>/s');
        foreach ($classroomStatusOptions as $index => $item) {
            $classroomStatusOptions[$index]['name'] = $this->stripBlankspace($item['name']);
        }

        // 借用院系
        preg_match('/借用院系.*?周次/s', $html, $borrowCollegeHtml);
        $borrowCollegeHtml = $borrowCollegeHtml ? $borrowCollegeHtml[0] : '';
        $borrowCollegeOptions = $this->formatOption($borrowCollegeHtml, '/<option.*?>(.*?)<\/option>/s', '/<option value="(.*)?"/');
        foreach ($borrowCollegeOptions as $index => $item) {
            $borrowCollegeOptions[$index]['name'] = $this->stripBlankspace($item['name']);
        }

        // 时间模式
        preg_match('/时间模式.*?教室所属单位/s', $html, $timeModelHtml);
        $timeModelHtml = $timeModelHtml ? $timeModelHtml[0] : '';
        $timeModelOptions = $this->formatOption($timeModelHtml, '', '/<option  value="(.*?)">/');

        // 教室所属单位
        preg_match('/教室所属单位.*?查 询/s', $html, $classroomOwnedHtml);
        $classroomOwnedHtml = $classroomOwnedHtml ? $classroomOwnedHtml[0] : '';
        $classroomOwnedOptions = $this->formatOption($classroomOwnedHtml, '/<option.*?>(.*?)<\/option>/s', '/<option value="(.*)?"/');
        foreach ($classroomOwnedOptions as $index => $item) {
            $classroomOwnedOptions[$index]['name'] = $this->stripBlankspace($item['name']);
        }

        return [
            'semester'        => $semester,
            'schoolArea'      => $schoolAreaOptions,
            'teachArea'       => $teachAreaOptions,
            'classroomType'   => $classroomTypeOptions,
            'peopleSign'      => $peopleSignOptions,
            'classroomStatus' => $classroomStatusOptions,
            'borrowCollege'   => $borrowCollegeOptions,
            'timeModel'       => $timeModelOptions,
            'classroomOwned'  => $classroomOwnedOptions
        ];
    }

    /**
     * 教室状态查询及详情所需参数
     * @param string $semester 学年学期
     * @param string $timeModel 时间模式
     * @param string $schoolArea 校区
     * @param string $teachArea 教学区
     * @param string $classroomType 教室类型
     * @param string $teachBuilding 教学楼
     * @param string $classroomCode 教室
     * @param string $peopleSign 容纳人数比较符号
     * @param string $peopleNum 容纳人数
     * @param string $classroomStatus 教室状态
     * @param string $borrowCollege 借用院系
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param string $classroomOwned 教室所属单位
     * @return array[]
     * @throws Exception
     */
    public function classroom(
        string $semester = '',
        string $timeModel = '',
        string $schoolArea = '',
        string $teachArea = '',
        string $classroomType = '',
        string $teachBuilding = '',
        string $classroomCode = '',
        string $peopleSign = '',
        string $peopleNum = '',
        string $classroomStatus = '',
        string $borrowCollege = '',
        string $weekStart = '',
        string $weekEnd = '',
        string $dayOfWeekStart = '',
        string $dayOfWeekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        string $classroomOwned = ''
    ): array
    {
        $postPara = [
            'typewhere'  => 'jszq',
            'xnxqh'      => $semester,
            'gnq_mh'     => '',
            'jsmc_mh'    => '',
            'syjs0601id' => '',
            'xqbh'       => $schoolArea,
            'jxqbh'      => $teachArea,
            'jslx'       => $classroomType,
            'jxlbh'      => $teachBuilding,
            'jsbh'       => $classroomCode,
            'bjfh'       => $peopleSign,
            'rnrs'       => $peopleNum,
            'jszt'       => $classroomStatus,
            'jyyx'       => $borrowCollege,
            'zc'         => $weekStart,
            'zc2'        => $weekEnd,
            'xq'         => $dayOfWeekStart,
            'xq2'        => $dayOfWeekEnd,
            'jc'         => $serialNoStart,
            'jc2'        => $serialNoEnd,
            'kbjcmsid'   => $timeModel,
            'ssdw'       => $classroomOwned,
        ];
        $post = http_build_query($postPara);
        $referer = $this->edusysUrl . '/jsxsd/kbxx/jsjy_query';
        $html = $this->httpPost('/jsxsd/kbxx/jsjy_query2', $post, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatClassroom($html['data']);
    }

    /**
     * 格式化匹配解析教室占用状态及详情所需参数
     * @param string $html
     * @return array[]
     */
    public function formatClassroom(string $html): array
    {
        $simpleHtml = $this->stripBlankspace($html);

        // input hidden para
        preg_match_all('/<input type="hidden" name="(.*?)"/', $simpleHtml, $paraNames);
        $paraNames = $paraNames ? $paraNames[1] : [];

        // input hidden value
        preg_match_all('/<input type="hidden" name=.*?value="(.*?)"/', $simpleHtml, $paraValues);
        $paraValues = $paraValues ? $paraValues[1] : [];

        $params = [];
        foreach ($paraNames as $index => $paraName) {
            $params[$paraName] = $paraValues[$index] ?? '';
        }

        // 教室名称
        preg_match_all('/name="jsids.*?\/>(.*?)</', $simpleHtml, $classroomNames);
        $classroomNames = $classroomNames ? $classroomNames[1] : [];

        // 教室编号
        preg_match_all('/jsbh="(.*?)" onclick/', $simpleHtml, $classroomCodes);
        $classroomCodes = $classroomCodes ? $classroomCodes[1] : [];

        // 表格内td值
        preg_match_all('/showJc1\(this\)">(.*?)<\/td>/', $simpleHtml, $tdHtmls);
        $tdHtmls = $tdHtmls ? $tdHtmls[1] : [];

        $classrooms = [];
        $classroomDayList = [];
        $classroomDay = [];
        $rowIndex = 0;
        $weekIndex = 0;
        foreach ($tdHtmls as $tdIndex => $tdHtml) {
            // 教室名称
            preg_match('/^(.*?)\(\d+\/\d+\)/', $classroomNames[$rowIndex], $classroomName);
            $classroomName = $classroomName ? $classroomName[1] : $classroomNames[$rowIndex];
            // 容纳人数
            preg_match('/\((\d+)\/\d+\)/', $classroomNames[$rowIndex], $capacity);
            $capacity = $capacity ? $capacity[1] : '';

            $serialIndex = $tdIndex % 6;
            $startAt = self::START_ATS[$serialIndex];
            $endAt = self::END_ATS[$serialIndex];
            // 教室每节状况
            $classroomDayList[] = [
                'content' => $this->stripHtmlTagAndBlankspace($tdHtml),
                'classroomCode' => $classroomCodes[$rowIndex] ?? '',
                'serialValue' => $this->getClassSerialNoValue($weekIndex, count($classroomDayList)),
                'dayOfWeek' => $weekIndex + 1,
                'startAt' => $startAt,
                'endAt' => $endAt
            ];

            if (count($classroomDayList) === 6) {
                $classroomDay[$weekIndex]['items'] = $classroomDayList;
                $classroomDay[$weekIndex]['title'] = "星期" . self::WEEKS_ARRAY[$weekIndex];
                $classroomDayList = [];
                $weekIndex++;
            }

            if ((42 * ($rowIndex + 1)) - 1 === $tdIndex) {
                $classrooms[$rowIndex]['classroom'] = $classroomName;
                $classrooms[$rowIndex]['items'] = $classroomDay;
                $classroomDayList = [];
                $classroomDay = [];
                $weekIndex = 0;
                $rowIndex++;
            }
        }

        return [
            'params' => $params,
            'classroom' => $classrooms
        ];
    }

    /**
     * 教学地点列表（教学区、教学楼、教室）
     * @param string $type 类型：area-教学区，building-教学楼，classroom-教室
     * @return array
     * @throws Exception
     */
    public function classroomList(string $type = 'classroom'): array
    {
        $requestType = 'newjs';
        if ($type === 'area') $requestType = 'jxq';         // 教学区列表
        if ($type === 'building') $requestType = 'jxl';     // 教学楼列表
        if ($type === 'classroom') $requestType = 'newjs';  // 教室列表

        $queryData = [ 'xqid' => '', 'requestType' => $requestType ];
        $uri = '/jsxsd/kbxx/jsjy_processAjax?' . http_build_query($queryData);
        $referer = $this->edusysUrl . '/jsxsd/kbxx/jsjy_query';
        $json =  $this->httpGet($uri, $this->cookie, $referer);

        $vaildJson = $this->checkCookieByHtml($json['data']);
        if ($vaildJson !== true) throw new Exception($vaildJson['data']);
        if ($json['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        $data = json_decode($json['data'], true);

        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'label' => $item['dmmc'],
                'value' => $item['dm']
            ];
        }

        return $list;
    }

    /**
     * 获取kcsj(课程时间?)参数值
     * @param int $dayOfWeekIndex 一周中的第几天，从0开始
     * @param int $serialIndex 一天中的第几节，从0开始
     * @return string
     */
    public function getClassSerialNoValue(int $dayOfWeekIndex, int $serialIndex): string
    {
        if ($dayOfWeekIndex < 0 || $dayOfWeekIndex > 6) return '';
        if ($serialIndex < 0 || $serialIndex > 5) return '';

        $dayOfWeekIndex = $dayOfWeekIndex + 1;
        switch ($serialIndex) {
            case 0:
                return $dayOfWeekIndex . '0102';
            case 1:
                return $dayOfWeekIndex . '0304';
            case 2:
                return $dayOfWeekIndex . '0506';
            case 3:
                return $dayOfWeekIndex . '0708';
            case 4:
                return $dayOfWeekIndex . '0910';
            case 5:
                return $dayOfWeekIndex . '111213';
            default:
                return '';
        }
    }

    /**
     * 获取教室借用详情信息
     * @param string $semester 学年学期
     * @param string $timeModel 时间模式
     * @param string $classroomCode 教室编码
     * @param string $serialValue 节次序号
     * @param string $dayOfWeek 星期几
     * @param string $startAt 开始时间
     * @param string $endAt 结束时间
     * @param string $dayOfWeekStart 开始星期几（值1~7）
     * @param string $dayOfWeekEnd 结束星期几（值1~7）
     * @param string $weekStart 开始周（值1~30）
     * @param string $weekEnd 结束周（值1~30）
     * @param string $serialNoStart 开始节数
     * @param string $serialNoEnd 结束节数
     * @param string $classroomStatus 教室状态
     * @return array
     * @throws Exception
     */
    public function classroomDetail(
        string $semester = '',
        string $timeModel = '',
        string $classroomCode = '',
        string $serialValue = '',
        string $dayOfWeek = '',
        string $startAt = '',
        string $endAt = '',
        string $dayOfWeekStart = '1',
        string $dayOfWeekEnd = '7',
        string $weekStart = '',
        string $weekEnd = '',
        string $serialNoStart = '',
        string $serialNoEnd = '',
        string $classroomStatus = ''
    ): array
    {
        $postData = [
            'xnxqh' => $semester,
            'jsbh' => $classroomCode,
            'kcsj' => $serialValue,
            'typewhere' => 'jszq',
            'startZc' => $weekStart,
            'endZc' => $weekEnd,
            'startJc' => $serialNoStart,
            'endJc' => $serialNoEnd,
            'startXq' => $dayOfWeekStart,
            'endXq' => $dayOfWeekEnd,
            'jszt' => $classroomStatus, // 教室状态参数？
            'type' => 'add',
            'kbjcmsid' => $timeModel,
            'xq' => $dayOfWeek,
            'kssj' => $startAt,
            'jssj' => $endAt,
            'tktime' => time() . '000', // 13位时间戳
        ];
        $uri = '/jsxsd/kbxx/jsjy_jszyqk?' . http_build_query($postData);
        $referer = $this->edusysUrl . '/jsxsd/kbxx/jsjy_query2';
        $html = $this->httpGet($uri, $this->cookie, $referer);
        $vaildHtml = $this->checkCookieByHtml($html['data']);
        if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
        if ($html['code'] !== self::CODE_SUCCESS) throw new Exception('获取失败');
        return $this->formatClassroomDetail($html['data']);
    }

    /**
     * 解析匹配格式化教室借用详情信息
     * @param string $html
     * @return array
     */
    public function formatClassroomDetail(string $html): array
    {
        $data = [];

        preg_match_all('/<table border="0".*?<\/table/s', $html, $tableHtmls);
        $tableHtmls = $tableHtmls ? $tableHtmls[0] : [];

        foreach ($tableHtmls as $tableHtml) {
            preg_match_all('/<td.*?>(.*?)<\/td/s', $tableHtml, $tds);
            $tds = $tds ? $tds[1] : [];
            $event = [];
            foreach ($tds as $tdIndex => $td) {
                if (($tdIndex - 1) % 3 === 0) continue;
                $index = intval($tdIndex / 3);
                if ($tdIndex % 3 === 0) $event[$index]['label'] = $this->stripHtmlTagAndBlankspace($td);
                if (($tdIndex - 2) % 3 === 0) $event[$index]['value'] = $this->stripHtmlTagAndBlankspace($td);
            }
            $data[] = $event;
        }

        return $data;
    }

}
