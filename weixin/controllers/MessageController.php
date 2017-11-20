<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:14
 */

namespace weixin\controllers;


use api\controllers\UserController;
use api\controllers\WeixinDataController;
use api\jd\pice\JdPiceSreach;
use api\jd\pice\JdPriceHistory;
use api\modelsfrom\AddUserFrom;
use api\modelsfrom\JDPromFrom;
use api\modelsfrom\JdSkuCouponFrom;
use api\weixin\accesstoken\WeixinAccessToken;
use api\weixin\request\TextRequestMsg;
use api\weixin\weixinapi\UserApi;
use api\weixin\WeixinReponse;
use yii\web\Controller;

class MessageController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionTest($id){

//        $this->text();
        $jd =new JdPiceSreach();
        $jdHistory = new JdPriceHistory();
        $url = "http://item.jd.com/{$id}.html";
        $token = $jdHistory->encrype($url,2,true);
//        $ree = [];
//        $price = 0;
        $title = '';
        $priceModle = $jd->getGoodPirceHistoryStrage($id,$token,$ree);
        var_dump($priceModle);
        var_dump($ree);exit();
//        json_decode()
//        var_dump($jd->unicode_decode('\u4f20\u4e16\u7ecf\u5178\u4e66\u4e1b\uff1a\u0055\u004e\u0049\u0058\u7f16\u7a0b\u827a\u672f'));
//        exit();
//        var_dump($jd::$curlHtmlDom);
        var_dump($priceModle);

        var_dump($ree);
        exit();

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

        $WeixinDataController = new WeixinDataController();
        $DataErr = [];

        $EventStr = null;
        if ($WeixinReponse->MsgType == 'event' ){
            //添加事件数量
            $countBool = $WeixinDataController->addMegTypeCount($WeixinReponse->appId,'event_'.$WeixinReponse->msgCx->Event,$DataErr);
            if (!$countBool){
                \Yii::error('添加公众号事件统计失败 res:'.json_encode($DataErr,JSON_UNESCAPED_SLASHES));
            }
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
        }else{
            //添加事件数量
            $countBool = $WeixinDataController->addMegTypeCount($WeixinReponse->appId,$WeixinReponse->MsgType,$DataErr);
            if (!$countBool){
                \Yii::error('添加公众号事件统计失败 res:'.json_encode($DataErr,JSON_UNESCAPED_SLASHES));
            }

            if ($WeixinReponse->MsgType == 'text') {
                $EventStr = $this->text();
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
        //{"app_id":["App ID cannot be blank."],"openid":["Openid cannot be blank."],"subscribe":["Subscribe cannot be blank."],"nickname":["Nickname cannot be blank."],"subscribe_time":["Subscribe Time cannot be blank."]}
        $userFrom->app_id = $WeixinReponse->appId;
        $userFrom->openid = $WeixinReponse->openId;
        $userFrom->subscribe = 1;
        $addBool = (new UserController())->addUser($userFrom,$errArr);
        if (empty($addBool)){
            \Yii::error('添加用户失败 res:'.json_encode($errArr,JSON_UNESCAPED_SLASHES));
            return null;
        }

        return null;
    }

    public function text(){
        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;
        //发送的文本
        $conut = $WeixinReponse->msgCx->Content;
        $urlArr = parse_url($conut);

        $TextRequestMsg = new TextRequestMsg();
        $TextRequestMsg->FromUserName = $WeixinReponse->appId;
        $TextRequestMsg->ToUserName = $WeixinReponse->openId;

        if (!isset($urlArr['scheme'])){
            $TextRequestMsg->Content = '在京东APP中点击分享 "复制链接" 发给我们  会有惊喜哦';
            return $TextRequestMsg->GetMessageXml();
        }
        if (!isset($urlArr['host'])){
            $TextRequestMsg->Content = '在京东APP中点击分享 "复制链接" 发给我们  会有惊喜哦';
            return $TextRequestMsg->GetMessageXml();
        }
        if (!isset($urlArr['path'])){
            $TextRequestMsg->Content = '在京东APP中点击分享 "复制链接" 发给我们  会有惊喜哦';
            return $TextRequestMsg->GetMessageXml();
        }

        if (strpos($urlArr['host'],'jd.com') === false){
            $TextRequestMsg->Content = '该链接不是京东的哦 在京东APP中点击分享 "复制链接" 发给我们  会有惊喜哦';
            return $TextRequestMsg->GetMessageXml();
        }

        //获取path中的商品id
        preg_match('/\d+/',$urlArr['path'],$pathArr);
        if (isset($pathArr[0]) && is_numeric($pathArr[0])){
            $jd =new JdPiceSreach();
            $errArr= [];

            if (!$resBool = $jd->getPriceStrage($pathArr[0],$price,$title,$errArr)){
                \Yii::error('获取商品失败 res:'.json_encode($errArr,JSON_UNESCAPED_SLASHES));
//                $TextRequestMsg->Content = '该商品 现价:'.$priceModle->newprice;
                $TextRequestMsg->Content = '商品查找失败';
                return $TextRequestMsg->GetMessageXml();
            }



            $TextRequestMsg->Content = "商品名称 \r ".$title." \r\n 现价:".round($price/100,2);

            //获取商品优惠券信息
            if ($promotionFroms = $jd->getGoodSkuCouponStrage($pathArr[0],$errArr)){
                $TextRequestMsg->Content .= "\r\n 优惠券信息:\r";
                /**
                 * @var JdSkuCouponFrom $promotionFrom
                 */
                foreach ($promotionFroms as $promotionFrom){
                    $TextRequestMsg->Content .= "满".$promotionFrom->quota."减".$promotionFrom->discount."\r";
                }
            }

            //获取商品满减少信息
            if ($proFroms = $jd->getGoodPromStrage($pathArr[0],$errArr)){
                $TextRequestMsg->Content .= "\r\n 促销信息:\r";
                /**
                 * @var JDPromFrom $proFrom
                 */
                foreach ($proFroms as $proFrom){
                    $TextRequestMsg->Content .= $proFrom->content."\r";
                }
            }


            //获取历史几个信息
            $jdHistory = new JdPriceHistory();
            $url = "http://item.jd.com/{$pathArr[0]}.html";
            $token = $jdHistory->encrype($url,2,true);
            if ($JdPriceHistory = $jd->getGoodPirceHistoryStrage($pathArr[0],$token,$errArr)){
//                $TextRequestMsg->Content .= "\r\n 历史价格信息:\r";
//                $pirceHistory = $JdPriceHistory->historyArr;
//                foreach ($pirceHistory as  $data){
//                    $TextRequestMsg->Content .= '时间'.$data['time'].' 价格:'.$data['price']."\r";
//                }
                if(empty($JdPriceHistory->historyArr)){
                    $TextRequestMsg->Content .= "\r\n 历史价格信息:\r";
                    $TextRequestMsg->Content.="当前商品未收录";
                }else {
                    $TextRequestMsg->Content .= "\r\n 历史价格信息:\r";
                    $lowerPrice = $JdPriceHistory->lowHistoryPirce;
                    $hightPrice = $JdPriceHistory->hightHistoryPirce;
                    $TextRequestMsg->Content .= '平均价格' . $JdPriceHistory->avePirce . "\r";
                    $TextRequestMsg->Content .= '最低价格' . $lowerPrice['price'] . ' 时间：' . $lowerPrice['time'] . "\r";
                    $TextRequestMsg->Content .= '最高价格' . $hightPrice['price'] . ' 时间：' . $hightPrice['time'] . "\r";
                }

            }

            return $TextRequestMsg->GetMessageXml();



        }else{
            $TextRequestMsg->Content = '该链接是无效的连接哦 在京东APP中点击分享 "复制链接" 发给我们  会有惊喜哦';
            return $TextRequestMsg->GetMessageXml();
        }


    }

    public function unsubscribe(){

        /**
         * @var WeixinReponse $WeixinReponse
         */
        $WeixinReponse = \Yii::$app->weixinReponse;
        $errArr = [];
        $addBool = (new UserController())->unSubscribe($WeixinReponse->appId,$WeixinReponse->openId,$errArr);
        if (empty($addBool)){
            \Yii::error('取消关注失败 res:'.json_encode($errArr,JSON_UNESCAPED_SLASHES));
            return null;
        }
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