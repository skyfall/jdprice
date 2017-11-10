<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午12:59
 */

namespace api\weixin\request;



class VideoRequestMsg extends \api\weixin\request\RequestMsg
{

    public $MediaId;

    public $Title;

    public $Description;
}