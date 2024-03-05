<?php

namespace Airmole\TjustbEdusys;

use Airmole\TjustbEdusys\Exception\Exception;

/**
 * 资料、学籍信息相关
 */
class Profile extends Base
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
    }

    /**
     * 获取账号个人信息
     * @return array
     * @throws Exception
     */
    public function getProfile(): array
    {
        if (empty($this->cookie)) throw new Exception('cookie不得为空');
        if (empty($this->usercode)) throw new Exception('学号参数不得为空');
        $referer = $this->edusysUrl . '/jsxsd/';
        if ($this->isStudent($this->usercode)) {
            $html = $this->httpGet('/jsxsd/grxx/xsxx', $this->cookie, $referer);
            $vaildHtml = $this->checkCookieByHtml($html['data']);
            if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
            $html['data'] = $this->formatStudentProfile($html['data']);
            return $html;
        } else {
            $html = $this->httpGet('/jsxsd/jsxx/queryjsxxjb', $this->cookie, $referer);
            $vaildHtml = $this->checkCookieByHtml($html['data']);
            if ($vaildHtml !== true) throw new Exception($vaildHtml['data']);
            $html['data'] = $this->formatTeacherProfile($html['data']);
            return $html;
        }
    }

    /**
     * 格式化匹配学生学籍资料信息
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatStudentProfile(string $html): array
    {
        $profile = [];
        try {
            preg_match("/院系：(.*)?</", $html, $college);
            $profile['college'] = $college[1] ?: '';

            preg_match("/专业：(.*)?</", $html, $profession);
            $profile['profession'] = $profession[1] ?: '';

            preg_match("/学制：(.*)?</", $html, $needStudyYear);
            $profile['needStudyYear'] = $needStudyYear[1] ?: '';

            preg_match("/班级：(.*)?</", $html, $className);
            $profile['className'] = $className[1] ?: '';

            preg_match("/学号：(.*)?</", $html, $usercode);
            $profile['usercode'] = $usercode[1] ?: '';

            preg_match("/姓名.*?>(.*)?>性别/s", $html, $name);
            $profile['name'] = $name[1] ?: '';

            preg_match("/性别.*?>(.*)?>姓名拼音/s", $html, $gender);
            $profile['gender'] = $gender[1] ?: '';

            preg_match("/姓名拼音.*?>(.*)?照片?/s", $html, $namePinyin);
            $profile['namePinyin'] = $namePinyin[1] ?: '';

            $profile['photo'] = $this->photo();

            preg_match("/出生日期.*?>(.*)?>婚否/s", $html, $birthday);
            $profile['birthday'] = $birthday[1] ?: '';

            preg_match("/婚否.*?>(.*)?>本人电话/s", $html, $marry);
            $profile['marry'] = $marry[1] ?: '';

            preg_match("/本人电话.*?>(.*)?>专业方向/s", $html, $mobile);
            $profile['mobile'] = $mobile[1] ?: '';

            preg_match("/专业方向.*?>(.*)?>政治面貌/s", $html, $professionDirection);
            $profile['professionDirection'] = $professionDirection[1] ?: '';

            preg_match("/政治面貌.*?>(.*)?>籍贯/s", $html, $politicalFace);
            $profile['politicalFace'] = $politicalFace[1] ?: '';

            preg_match("/籍贯.*?>(.*)?>入党团时间/s", $html, $homeplace);
            $profile['homeplace'] = $homeplace[1] ?: '';

            preg_match("/入党团时间.*?>(.*)?>民族/s", $html, $joinPartyDate);
            $profile['joinPartyDate'] = $joinPartyDate[1] ?: '';

            preg_match("/民族.*?>(.*)?>学习形式/s", $html, $nation);
            $profile['nation'] = $nation[1] ?: '';

            preg_match("/学习形式.*?>(.*)?>学习层次/s", $html, $studyForm);
            $profile['studyForm'] = $studyForm[1] ?: '';

            preg_match("/学习层次.*?>(.*)?>外语种类/s", $html, $studyLayer);
            $profile['studyLayer'] = $studyLayer[1] ?: '';

            preg_match("/外语种类.*?>(.*)?>家庭现住址/s", $html, $foreignLanguage);
            $profile['foreignLanguage'] = $foreignLanguage[1] ?: '';

            preg_match("/家庭现住址.*?>(.*)?>火车到站/s", $html, $homeAddress);
            $profile['homeAddress'] = $homeAddress[1] ?: '';

            preg_match("/火车到站.*?>(.*)?>邮政编码/s", $html, $trainStation);
            $profile['trainStation'] = $trainStation[1] ?: '';

            preg_match("/邮政编码.*?>(.*)?>家庭电话/s", $html, $postcode);
            $profile['postcode'] = $postcode[1] ?: '';

            preg_match("/家庭电话.*?>(.*)?>联系人/s", $html, $homeTel);
            $profile['homeTel'] = $homeTel[1] ?: '';

            preg_match("/联系人.*?>(.*)?>省级/s", $html, $contacter);
            $profile['contacter'] = $contacter[1] ?: '';

            preg_match("/省级.*?>(.*)?>市级/s", $html, $province);
            $profile['province'] = $province[1] ?: '';

            preg_match("/市级.*?>(.*)?>区级/s", $html, $city);
            $profile['city'] = $city[1] ?: '';

            preg_match("/区级.*?>(.*)?>学籍号/s", $html, $county);
            $profile['county'] = $county[1] ?: '';

            preg_match("/入学日期.*?>(.*)?>毕业日期/s", $html, $joinSchoolDate);
            $profile['joinSchoolDate'] = $joinSchoolDate[1] ?: '';

            preg_match("/毕业日期.*?>(.*)?>入学考号/s", $html, $graduateDate);
            $profile['graduateDate'] = $graduateDate[1] ?: '';

            preg_match("/入学考号.*?>(.*)?>身份证/s", $html, $ceeCode);
            $profile['ceeCode'] = $ceeCode[1] ?: '';

            preg_match("/身份证编号.*?>(.*)?>毕\(结\)业证书号/s", $html, $idcard);
            $profile['idcard'] = $idcard[1] ?: '';

            preg_match("/毕\(结\)业证书号.*?>(.*)?>学士证书号/s", $html, $graduateCertNo);
            $profile['graduateCertNo'] = $graduateCertNo[1] ?: '';

            preg_match("/学士证书号.*?>(.*)?>备注/s", $html, $bachelorCertNo);
            $profile['bachelorCertNo'] = $bachelorCertNo[1] ?: '';

        } catch (\Exception $e) {
            throw new Exception('获取失败' . $e->getMessage());
        }

        foreach ($profile as $key => $value) {
            if ($key === 'photo') continue;
            $profile[$key] = $this->stripHtmlTagAndBlankspace($value);
        }

        return $profile;
    }

    /**
     * 获取学生照片(base64)
     * @return string
     */
    public function photo(): string
    {
        $referer = $this->edusysUrl . '/jsxsd/grxx/xsxx';
        $response = $this->httpGet('/jsxsd/grxx/xszpLoad', $this->cookie, $referer);
        if ($response['code'] !== Base::CODE_SUCCESS) return '';
        if (strpos($response['data'], 'authserver.bkty.top/authserver/login')) return '';
        return base64_encode($response['data']);
    }

    /**
     * 格式化匹配教师基本信息
     * @param string $html
     * @return array
     * @throws Exception
     */
    public function formatTeacherProfile(string $html): array
    {
        $profile = [];
        try {
            preg_match("/教工号：(.*)?姓名：/s", $html, $usercode);
            $profile['usercode'] = $usercode[1] ?: '';

            preg_match("/姓名：(.*)?曾用名：/s", $html, $name);
            $profile['name'] = $name[1] ?: '';

            preg_match("/性别：(.*)?出生日期/s", $html, $gender);
            $profile['gender'] = $gender[1] ?: '';

            preg_match("/出生日期：(.*)?出生地：/s", $html, $birthday);
            $profile['birthday'] = $birthday[1] ?: '';

            preg_match("/国籍：(.*)?民族：/s", $html, $country);
            $profile['country'] = $country[1] ?: '';

            preg_match("/民族：(.*)?证件类型：/s", $html, $nation);
            $profile['nation'] = $nation[1] ?: '';

            preg_match("/证件类型：(.*)?证件号码：/s", $html, $idcardType);
            $profile['idcardType'] = $idcardType[1] ?: '';

            preg_match("/证件号码：(.*)?编制类别：/s", $html, $idcard);
            $profile['idcard'] = $idcard[1] ?: '';

            preg_match("/编制类别：(.*)?教职工类别：/s", $html, $jobType);
            $profile['jobType'] = $jobType[1] ?: '';

            preg_match("/教职工类别：(.*)?当前状态：/s", $html, $teacherType);
            $profile['teacherType'] = $teacherType[1] ?: '';

            preg_match("/当前状态：(.*)?档案编号：/s", $html, $workStatus);
            $profile['workStatus'] = $workStatus[1] ?: '';

            preg_match("/健康状况：(.*)?血型：/s", $html, $health);
            $profile['health'] = $health[1] ?: '';

            preg_match("/所属单位：(.*)?港澳台侨胞：/s", $html, $college);
            $profile['college'] = $college[1] ?: '';

            preg_match("/电子信箱：(.*)?办公电话：/s", $html, $email);
            $profile['email'] = $email[1] ?: '';
        } catch (\Exception $e) {
            throw new Exception('获取失败' . $e->getMessage());
        }

        foreach ($profile as $key => $value) {
            $profile[$key] = str_replace('*', '', $this->stripHtmlTagAndBlankspace($value));
        }

        return $profile;
    }

}