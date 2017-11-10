<?php
namespace frontend\controllers;

use api\weixin\request\TextRequestMsg;
use api\weixin\WeixinReponse;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionTest(){
//        $WeixinReponse = new WeixinReponse();
//        var_dump(\Yii::$app->weixinReponse);

        $TextRequestMsg = new TextRequestMsg();
        $TextRequestMsg->Content = '1111';
        var_dump($TextRequestMsg->GetMessageXml());exit();
    }
}
