<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午11:48
 */

namespace api\weixin\weixinapi;


use yii\base\Object;

class BaseApi extends Object
{

    public static $curl;

    public function init(){
       if (empty(self::$curl)){
           self::$curl = curl_init();
       }
    }

    /**
     * 调用接口获取access_token
     * @link  https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140183
     * @param $appid  公众号的appid
     * @param $secret 公众号的密钥
     * @return array
     */
    public function getAccessToken($appid,$secret){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        return $this->CurlGet($url);
    }

    public function CurlGet($url){
        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$curl, CURLOPT_HEADER, 0);
        $output = curl_exec(self::$curl);
        return json_decode($output,true);
    }
}