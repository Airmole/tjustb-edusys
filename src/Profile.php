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
            $vaildtml = $this->checkCookieByHtml($html['data']);
            if ($vaildtml !== true) throw new Exception($vaildtml['data']);
            $html['data'] = $this->formatStudentProfile($html['data']);
            return $html;
        } else {
            throw new Exception('暂不支持教师账号，开发中...');
        }
    }

    /**
     * 格式化匹配学生学籍资料信息
     * @param string $html
     * @return array
     */
    public function formatStudentProfile(string $html): array
    {
        $profile = [];
        preg_match("/院系：(.*)?</", $html,$college);
        $profile['college'] = $college[1] ?: '';

        preg_match("/专业：(.*)?</", $html,$profession);
        $profile['profession'] = $profession[1] ?: '';

        preg_match("/学制：(.*)?</", $html,$needStudyYear);
        $profile['needStudyYear'] = $needStudyYear[1] ?: '';

        preg_match("/班级：(.*)?</", $html,$className);
        $profile['className'] = $className[1] ?: '';

        preg_match("/学号：(.*)?</", $html,$usercode);
        $profile['usercode'] = $usercode[1] ?: '';

        preg_match("/姓名.*?>(.*)?>性别/s", $html,$name);
        $profile['name'] = $name[1] ?: '';

        preg_match("/性别.*?>(.*)?>姓名拼音/s", $html,$gender);
        $profile['gender'] = $gender[1] ?: '';

        preg_match("/姓名拼音.*?>(.*)?照片?/s", $html,$namePinyin);
        $profile['namePinyin'] = $namePinyin[1] ?: '';

        $profile['photo'] = $this->photo();

        preg_match("/出生日期.*?>(.*)?>婚否/s", $html,$birthday);
        $profile['birthday'] = $birthday[1] ?: '';

        preg_match("/婚否.*?>(.*)?>本人电话/s", $html,$marry);
        $profile['marry'] = $marry[1] ?: '';

        preg_match("/本人电话.*?>(.*)?>专业方向/s", $html,$mobile);
        $profile['mobile'] = $mobile[1] ?: '';

        preg_match("/专业方向.*?>(.*)?>政治面貌/s", $html,$professionDirection);
        $profile['professionDirection'] = $professionDirection[1] ?: '';

        preg_match("/政治面貌.*?>(.*)?>籍贯/s", $html,$politicalFace);
        $profile['politicalFace'] = $politicalFace[1] ?: '';

        preg_match("/籍贯.*?>(.*)?>入党团时间/s", $html,$homeplace);
        $profile['homeplace'] = $homeplace[1] ?: '';

        preg_match("/入党团时间.*?>(.*)?>民族/s", $html,$joinPartyDate);
        $profile['joinPartyDate'] = $joinPartyDate[1] ?: '';

        preg_match("/民族.*?>(.*)?>学习形式/s", $html,$nation);
        $profile['nation'] = $nation[1] ?: '';

        preg_match("/学习形式.*?>(.*)?>学习层次/s", $html,$studyForm);
        $profile['studyForm'] = $studyForm[1] ?: '';

        preg_match("/学习层次.*?>(.*)?>外语种类/s", $html,$studyLayer);
        $profile['studyLayer'] = $studyLayer[1] ?: '';

        preg_match("/外语种类.*?>(.*)?>家庭现住址/s", $html,$foreignLanguage);
        $profile['foreignLanguage'] = $foreignLanguage[1] ?: '';

        preg_match("/家庭现住址.*?>(.*)?>火车到站/s", $html,$homeAddress);
        $profile['homeAddress'] = $homeAddress[1] ?: '';

        preg_match("/火车到站.*?>(.*)?>邮政编码/s", $html,$trainStation);
        $profile['trainStation'] = $trainStation[1] ?: '';

        preg_match("/邮政编码.*?>(.*)?>家庭电话/s", $html,$postcode);
        $profile['postcode'] = $postcode[1] ?: '';

        preg_match("/家庭电话.*?>(.*)?>联系人/s", $html,$homeTel);
        $profile['homeTel'] = $homeTel[1] ?: '';

        preg_match("/联系人.*?>(.*)?>省级/s", $html,$contacter);
        $profile['contacter'] = $contacter[1] ?: '';

        preg_match("/省级.*?>(.*)?>市级/s", $html,$province);
        $profile['province'] = $province[1] ?: '';

        preg_match("/市级.*?>(.*)?>区级/s", $html,$city);
        $profile['city'] = $city[1] ?: '';

        preg_match("/区级.*?>(.*)?>学籍号/s", $html,$county);
        $profile['county'] = $county[1] ?: '';

        preg_match("/入学日期.*?>(.*)?>毕业日期/s", $html,$joinSchoolDate);
        $profile['joinSchoolDate'] = $joinSchoolDate[1] ?: '';

        preg_match("/毕业日期.*?>(.*)?>入学考号/s", $html,$graduateDate);
        $profile['graduateDate'] = $graduateDate[1] ?: '';

        preg_match("/入学考号.*?>(.*)?>身份证/s", $html,$ceeCode);
        $profile['ceeCode'] = $ceeCode[1] ?: '';

        preg_match("/身份证编号.*?>(.*)?>毕\(结\)业证书号/s", $html,$idcard);
        $profile['idcard'] = $idcard[1] ?: '';

        preg_match("/毕\(结\)业证书号.*?>(.*)?>学士证书号/s", $html,$graduateCertNo);
        $profile['graduateCertNo'] = $graduateCertNo[1] ?: '';

        preg_match("/学士证书号.*?>(.*)?>备注/s", $html,$bachelorCertNo);
        $profile['bachelorCertNo'] = $bachelorCertNo[1] ?: '';

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
        return base64_encode($response['data']);
    }

}