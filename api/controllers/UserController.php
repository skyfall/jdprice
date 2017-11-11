<?php
namespace api\controllers;
use api\models\WeixinUser;
use api\modelsfrom\AddUserFrom;
use yii\base\Object;

/**
 * Created by PhpStorm.
 * 微信用户类
 * User: sun
 * Date: 2017/11/10
 * Time: 下午6:05
 */

class UserController extends Object{

    /**
     * 添加或者更新用户表信息 成功返回true 失败返回false
     * @param AddUserFrom $userFrom
     * @param array $errArr 错误信息的数组
     * @return bool
     */
    public function addUser(AddUserFrom $userFrom,array &$errArr){
        $WeixinUser = WeixinUser::findOne(['app_id'=>$userFrom->app_id,'openid'=>$userFrom->openid]);
        if (empty($WeixinUser)){
            $WeixinUser = new WeixinUser();
            $WeixinUser->creaate_at = time();
        }else{
            $userFrom->load($WeixinUser->getAttributes(),'');
        }
        $WeixinUser->load($userFrom->getAttributes(),'');
        $WeixinUser->update_at = time();
        if ($WeixinUser->save()){
            return true;
        }
        $errArr = $WeixinUser->errors;
        return false ;
    }


    /**
     * 用户取消关注
     * @param $app_id
     * @param $openid
     * @param array $errArr
     * @return bool
     */
    public function unSubscribe($app_id,$openid,array $errArr){
        $WeixinUser = WeixinUser::findOne(['app_id'=>$app_id,'openid'=>$openid]);
        if (!empty($WeixinUser)){
            $WeixinUser->subscribe = 0;
            $WeixinUser->update_at = time();
            $WeixinUser->save();
            return true;
        }
        $errArr['unSubscribe'][] = 'appid:'.$app_id.' openid:'.$openid.' not find user';
        return false;
    }
}
