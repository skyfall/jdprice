<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午11:01
 */

namespace api\weixin\response\weixinevent;


use api\weixin\response\WeixinMessage;


class SubscribeEvent extends WeixinMessage
{
    public $EventKey;

    public $Ticket;

}