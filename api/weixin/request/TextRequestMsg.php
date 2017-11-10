<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午12:58
 */

namespace api\weixin\request;



class TextRequestMsg extends \api\weixin\request\RequestMsg
{

    public $MsgType = 'text';

    public $Content;
}