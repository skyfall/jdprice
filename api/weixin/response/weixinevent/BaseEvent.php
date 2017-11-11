<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午11:36
 */

namespace api\weixin\response\weixinevent;


use api\weixin\response\WeixinMessage;

class BaseEvent extends WeixinMessage
{

    public $Event = null;

    public $EventArr = [
        'subscribe'=>[
            'class'=>'api\weixin\response\weixinevent\SubscribeEvent',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'SCAN'=>[
            'class'=>'api\weixin\response\weixinevent\ScanEvent',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'LOCATION'=>[
            'class'=>'api\weixin\response\weixinevent\LocationEvent',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'CLICK'=>[
            'class'=>'api\weixin\response\weixinevent\ClickEvent',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
        'VIEW'=>[
            'class'=>'api\weixin\response\weixinevent\ViewEvnet',
            'initFun'=>'MessageInit',
            'parameter'=>[],
        ],
    ];

    public function  MessageInit($postObj){
        $Event = isset($postObj['Event']) ? $postObj['Event'] : '';
        if (isset($this->EventArr[$Event])){
            $class = $this->EventArr[$Event]['class'];
            $initFun = $this->EventArr[$Event]['initFun'];
            $parameter = $this->EventArr[$Event]['parameter'];

            return (new $class())->$initFun(array_merge($postObj,$parameter));
        }
        return $this;
    }


}