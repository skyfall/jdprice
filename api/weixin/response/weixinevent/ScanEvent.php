<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午11:03
 */

namespace api\weixin\response\weixinevent;


use api\weixin\response\WeixinMessage;


class ScanEvent extends WeixinMessage
{
    public $EventKey;

    public $Ticket;

}