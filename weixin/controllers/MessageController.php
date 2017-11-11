<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:14
 */

namespace weixin\controllers;


use api\controllers\UserController;
use api\modelsfrom\AddUserFrom;
use api\weixin\accesstoken\WeixinAccessToken;
use api\weixin\request\TextRequestMsg;
use api\weixin\weixinapi\UserApi;
use api\weixin\WeixinReponse;
use yii\web\Controller;

class MessageController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionTest(){
        $errArr = [];
        $access_token = (new WeixinAccessToken())->getAccessToken('wx3929189dbf11f00c',$errArr);
        var_dump($access_token);
        var_dump($errArr);exit();
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
        var_dump($WeixinReponse);exit();

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

        $EventStr = null;
        if ($WeixinReponse->MsgType == 'event' ){
            switch ($WeixinReponse->msgCx->Event){
                case 'subscribe':
                    $EventStr = $this->subscribe();
                    break;
                case 'unsubscribe':
                    $EventStr = $this->unsubscribe();
                    break;
                case 'SCAN':
                    $EventStr = $this->scan();
                    break;
                case 'LOCATION':
                    $EventStr = $this->location();
                    break;
                case 'CLICK':
                    $EventStr = $this->click();
                    break;
                case 'VIEW':
                    $EventStr = $this->view();
                    break;
                default:
                    $EventStr = $this->noFind();
                    break;
            }
        }

        return empty($EventStr) ? \Yii::$app->request->get('echostr','success') : $EventStr;

    }


    public function subscribe(){
        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;

        $errArr = [];
        //获取access_token
        $access_token = (new WeixinAccessToken())->getAccessToken($WeixinReponse->appId,$errArr);
        if (empty($access_token)){
            \Yii::error('公众号获取access_token失败 res:'.json_encode($errArr,JSON_UNESCAPED_SLASHES));
            return null;
        }

        //获取用户信息
        $userInf = (new UserApi())->userInfo($access_token,$WeixinReponse->openId);
        if (empty($userInf)){
            \Yii::error('获取用户信息失败 res:'.json_encode($userInf,JSON_UNESCAPED_SLASHES));
            return null;
        }

        //添加用户信息
        $userFrom = new AddUserFrom();
        $userFrom->load($userInf,'');
        $addBool = (new UserController())->addUser($userFrom,$errArr);
        if (empty($addBool)){
            \Yii::error('添加用户失败 res:'.json_encode($errArr,JSON_UNESCAPED_SLASHES));
            return null;
        }

        return null;
    }

    public function unsubscribe(){
        return null;
    }

    public function scan(){
        return null;
    }

    public function location(){
        return null;
    }

    public function click(){
        return null;
    }

    public function view(){
        return null;
    }

    public function noFind(){
        return null;
    }
}