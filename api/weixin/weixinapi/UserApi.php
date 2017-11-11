<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 下午12:09
 */

namespace api\weixin\weixinapi;

use api\weixin\weixinapi\BaseApi;

class UserApi extends BaseApi
{

    /**
     * 获取用户信息
     * @link  https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140839
     * @param $access_token     调用令牌
     * @param $openId           用户的openid
     * @param string $lang      语音版本
     * @return array            返回用户的基本信息
     */
    public function userInfo($access_token,$openId,$lang = 'zh_CN'){
        $Url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openId}&lang={$lang}";
        return $this->CurlGet($Url);
    }

}