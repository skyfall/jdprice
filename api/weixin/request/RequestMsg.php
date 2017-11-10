<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 上午1:01
 */

namespace api\weixin\request;


use yii\base\Object;

class RequestMsg extends Object
{

    public $ToUserName;

    public $FromUserName;

    public $CreateTime;

    public function GetMessageXml(){
        $this->CreateTime = time();
        $array = [];
        foreach ($this as $name=>$values){
            $array[$name] = $values;
        }

        return $this->arrayToXml($array);
    }

    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}