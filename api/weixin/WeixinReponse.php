<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午11:16
 */

namespace api\weixin;


use api\weixin\response\WeixinMessage;
use yii\base\Object;

class WeixinReponse extends Object
{

    /**
     * @var WeixinMessage $msgType
     */
    public $msgType;

    //用户的openid
    public $openId;

    //公众号的appid
    public $appId;

    //消息类型
    public $MsgType;

    public $MsgTypeClass = [
        'text'=>[
            'class'=>'api\weixin\response\weixinmsg\TextMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'image'=>[
            'class'=>'api\weixin\response\weixinmsg\ImgMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'voice'=>[
            'class'=>'api\weixin\response\weixinmsg\VoiceMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'link'=>[
            'class'=>'api\weixin\response\weixinmsg\LinkMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'video'=>[
            'class'=>'api\weixin\response\weixinmsg\VideoMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'shortvideo'=>[
            'class'=>'api\weixin\response\weixinmsg\ShortvideoMsg',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'event'=>[
            'class'=>'api\weixin\response\weixinevent\BaseEvent',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ]
    ];

    public $postStr;

    public function init(){
        if (!empty($this->msgType)){
            return null;
        }


        $postStr = file_get_contents('php://input');
        $postObj = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (empty($postObj)){
            return false;
        }

        isset($postObj['FromUserName']) ?  $this->openId = $postObj['FromUserName'] : '';
        isset($postObj['ToUserName']) ? $this->appId = $postObj['ToUserName'] : '';
        isset($postObj['MsgType']) ? $this->MsgType = $postObj['MsgType'] : '';

        if (isset($this->MsgTypeClass[$this->MsgType])){
            $class = $this->MsgTypeClass[$this->MsgType]['class'];
            $initFun = $this->MsgTypeClass[$this->MsgType]['initFun'];
            $parameter = $this->MsgTypeClass[$this->MsgType]['parameter'];
            $parameter['openid'] = $this->openId;
            $parameter['app_id'] = $this->appId;
            $this->msgType = (new $class())->$initFun(array_merge($postObj,$parameter));
        }
        return true;
    }
}