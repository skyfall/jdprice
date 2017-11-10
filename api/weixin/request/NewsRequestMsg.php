<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:00
 */

namespace api\weixin\request;



class NewsRequestMsg extends \api\weixin\request\RequestMsg
{

    public $ArticleCount;

    public $Articles;

    public $Title;

    public $Description;

    public $PicUrl;

    public $Url;

}