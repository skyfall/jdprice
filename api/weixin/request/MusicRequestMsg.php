<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:00
 */

namespace api\weixin\request;



class MusicRequestMsg extends \api\weixin\request\RequestMsg
{
    public $Title;

    public $Description;

    public $MusicURL;

    public $HQMusicUrl;

    public $ThumbMediaId;
}