<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午10:59
 */

namespace api\weixin\response\weixinmsg;



class LocationMsg extends \api\weixin\response\WeixinMessage
{
    public $Location_X;

    public $Location_Y;

    public $Scale;

    public $Label;

    public $MsgId;

}