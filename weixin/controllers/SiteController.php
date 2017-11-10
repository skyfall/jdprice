<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 上午11:35
 */

namespace weixin\controllers;


use api\weixin\request\TextRequestMsg;

use api\weixin\WeixinReponse;
use yii\web\Controller;

class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionTest(){
        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;

        $TextRequestMsg = new TextRequestMsg();
        $TextRequestMsg->FromUserName = $WeixinReponse->openId;
        $TextRequestMsg->ToUserName = $WeixinReponse->appId;
        $TextRequestMsg->Content = '1111';
        var_dump($TextRequestMsg->GetMessageXml());exit();


    }
}