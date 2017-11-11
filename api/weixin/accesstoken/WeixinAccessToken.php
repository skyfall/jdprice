<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午11:39
 */

namespace api\weixin\accesstoken;


use api\weixin\weixinapi\BaseApi;
use yii\base\Object;

class WeixinAccessToken extends Object
{

    /**
     * 获取令牌
     * @param $appid
     * @param $errArr
     * @return bool|string
     */
    public function getAccessToken($appid,&$errArr){

        if(!isset(\Yii::$app->params['appList'][$appid])){
            $errArr['getAccessToken'][] = 'appid:'.$appid.' 不存在';
            return false;
        }

        $WeixinAccessTokenModle = \api\models\WeixinAccessToken::findOne(['app_id'=>$appid]);
        if (!empty($WeixinAccessTokenModle) &&
            $WeixinAccessTokenModle->update_at+\Yii::$app->params['appAccessTokenTtl']>= time()
        ){
            return $WeixinAccessTokenModle->access_token;
        }elseif (empty($WeixinAccessTokenModle)){
            $WeixinAccessTokenModle = new \api\models\WeixinAccessToken();
            $WeixinAccessTokenModle->create_at = time();
            $WeixinAccessTokenModle->app_id = $appid;
        }else{
            //乐观锁  控制并发  更新到期时间 为到期前10秒 保证 并发时候进程不会重复更新
            $upTime =time() - \Yii::$app->params['appAccessTokenTtl'] + 10;
            $res = \api\models\WeixinAccessToken::updateAll(['update_at'=>$upTime],
                'id = :id and update_at = :update_at',
                [':id'=>$WeixinAccessTokenModle->id,':update_at'=>$WeixinAccessTokenModle->update_at]);
            if (!$res){
                $errArr['getAccessToken'][] = 'appid:'.$appid.' 乐观锁锁定令牌失败';
                return false;
            }
        }

        $secret = \Yii::$app->params['appList'][$appid]['EncodingAESKey'];
        $app_id = \Yii::$app->params['appList'][$appid]['appid'];
        //调用api接口获取令牌
        $resArr = (new BaseApi())->getAccessToken($app_id,$secret);
        if (!isset($resArr['access_token'])){
            $errArr['getAccessToken'][] = '请求接口获取令牌失败';
            $errArr['getAccessToken'][] = 'res: '.json_encode($resArr);
            return false;
        }

        $WeixinAccessTokenModle->update_at = time();
        $WeixinAccessTokenModle->access_token = $resArr['access_token'];
        if ($WeixinAccessTokenModle->save()){
            return $WeixinAccessTokenModle->access_token;
        }

        $errArr['getAccessToken'][] = '保存令牌失败 res:'.json_encode($WeixinAccessTokenModle->errors);
        return $resArr['access_token'];


    }



}