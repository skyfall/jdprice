<?php
/**
 * 京东历史价格数据
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/20
 * Time: 下午12:42
 */

namespace api\modelsfrom;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class JdPirceHistoryFrom extends Model
{
    public $datePrice="";
    public $siteName="";
    public $siteId="";
    public $zouShi="";
    public $bjid="";
    public $lowerPrice="";
    public $lowerDate="";
    public $spName="";
    public $currentPrice="";
    public $spPic="";
    public $spUrl="";
    public $spbh="";
    public $fromType="";

    public $historyArr = [];

    public function rules()
    {
        return [
            [
                [
                    "datePrice","siteName","siteId","zouShi","bjid","lowerPrice","lowerDate","spName","currentPrice","spPic","spUrl","spbh","fromType"
                ],
                'trim'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            "datePrice",
            "siteName",
            "siteId",
            "zouShi",
            "bjid",
            "lowerPrice",
            "lowerDate",
            "spName",
            "currentPrice",
            "spPic",
            "spUrl",
            "spbh",
            "fromType",
        ];
    }

    public function fixHistoryArr(){
        $datePrice = $this->datePrice;
        $datePrice = substr($datePrice,1);
        $datePrice = substr($datePrice,0,strlen($datePrice)-1);
        $datePriceArr = explode('],[',$datePrice);
        $historyArr =[];
        foreach ($datePriceArr as $data){
            $dataArr = explode('),',$data);
            if (!isset($dataArr[0])){
                $this->addError('datePrice','分析数据时候 找不到标签');
                continue;
            }
            if (!isset($dataArr[1])){
                $this->addError('datePrice','分析数据时候 找不到价格');
                continue;
            }
            $time = str_replace('Date.UTC(','',$dataArr[0]);
            $price = $dataArr[1];
            $historyArr[] = [
                'time'=>$time,
                'price'=>$price,
                'timestamp'=>str_replace(',','',$time)
            ];
        }

        ArrayHelper::multisort($historyArr,['timestamp'],[SORT_ASC]);
        $this->historyArr = $historyArr;
    }

}