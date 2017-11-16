<?php
/**
 * 商品活动信息 促销信息
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/17
 * Time: 上午12:24
 */

namespace api\modelsfrom;


use yii\base\Model;

class JDPromFrom extends Model
{
    public $d;
    public $st;
    public $code;
    public $content;
    public $tr;
    public $adurl;
    public $name;
    public $pid;

    public function rules()
    {
        return [
            [
                [
                    'd','st','code','content','tr','adurl','name','pid',
                ],
                'trim'
            ],
        ];
    }

    public function attributeLabels(){
        return [
            "st"=>"",
            "code"=>"",
            "content"=>"",
            "tr"=>"",
            "adurl"=>"",
            "name"=>"",
            "pid"=>"",
        ];
    }

}