<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午10:45
 */

namespace api\weixin\response;


use yii\base\Object;

class WeixinMessage extends Object
{

    /**
     * @var 消息的类型
     */
    public $MsgType;

    /**
     * @var 用户的openid
     */
    public $openid;

    /**
     * @var 公众号的类型
     */
    public $app_id;


    /**
     * @var 消息创建时间 （整型）
     */
    public $CreateTime;

    /**
     * @var 消息id，64位整型
     */
    public $MsgId;


    public function MessageInit($parameter){
        foreach ($this as $name => $value) {
            isset($parameter[$name]) ? $this->$name = $parameter[$name] : '';
        }
        return $this;
    }
}