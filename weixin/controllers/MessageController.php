<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:14
 */

namespace weixin\controllers;


use api\weixin\request\TextRequestMsg;
use api\weixin\WeixinReponse;
use yii\web\Controller;

class MessageController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionTest(){
        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;
        if ($WeixinReponse->MsgType == 'text') {
            $TextRequestMsg = new TextRequestMsg();
            $TextRequestMsg->FromUserName = $WeixinReponse->appId;
            $TextRequestMsg->ToUserName = $WeixinReponse->openId;
            $TextRequestMsg->Content = $WeixinReponse->msgCx->Content;
            return $TextRequestMsg->GetMessageXml();
        }

        return 'success';
    }


    public function actionIndex(){
        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;
        if ($WeixinReponse->MsgType == 'text') {
            $TextRequestMsg = new TextRequestMsg();
            $TextRequestMsg->FromUserName = $WeixinReponse->appId;
            $TextRequestMsg->ToUserName = $WeixinReponse->openId;
            $TextRequestMsg->Content = $WeixinReponse->msgCx->Content;
            return $TextRequestMsg->GetMessageXml();
        }

        return 'success';
    }
}