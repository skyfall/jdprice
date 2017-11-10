<?php
namespace api\weixin\response\weixinmsg;

/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午10:55
 */

class VoiceMsg extends \api\weixin\response\WeixinMessage
{
    public $MediaId;

    public $Format;

    public $MsgID;

    public $Recognition;

}