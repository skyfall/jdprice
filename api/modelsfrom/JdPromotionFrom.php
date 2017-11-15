<?php
/**
 * 京东优惠券信息
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/15
 * Time: 下午11:11
 */

namespace api\modelsfrom;


use yii\base\Model;

class JdPromotionFrom extends Model
{
    public $couponType;
    public $trueDiscount;
    public $couponKind;
    public $discountDesc;
    public $beginTime;
    public $userClass;
    public $url;
    public $overlapDesc;
    public $couponStyle;
    public $area;
    public $hourCoupon;
    public $overlap;
    public $endTime;
    public $key;
    public $addDays;
    public $quota;
    public $toUrl;
    public $timeDesc;
    public $roleId;
    public $discount;
    public $discountFlag;
    public $limitType;
    public $name;
    public $batchId;

    public function rules()
    {
        return [
            [
                [
                    'couponType','couponType','trueDiscount','couponKind','discountDesc','beginTime','userClass','url',
                    'overlapDesc','couponStyle','area','hourCoupon','overlap','endTime','key','addDays','quota','toUrl',
                    'timeDesc','roleId','discount','discountFlag','limitType','name','batchId'
                ],
                'trim'
            ],
        ];
    }

    public function attributeLabels(){
        return [
            "couponType"=>"",
            "couponType"=>"",
            "trueDiscount"=>"",
            "couponKind"=>"",
            "discountDesc"=>"",
            "beginTime"=>"",
            "userClass"=>"",
            "url"=>"",
            "overlapDesc"=>"",
            "couponStyle"=>"",
            "area"=>"",
            "hourCoupon"=>"",
            "overlap"=>"",
            "endTime"=>"",
            "key"=>"",
            "addDays"=>"",
            "quota"=>"",
            "toUrl"=>"",
            "timeDesc"=>"",
            "roleId"=>"",
            "discount"=>"",
            "discountFlag"=>"",
            "limitType"=>"",
            "name"=>"",
            "batchId"=>"",
        ];
    }



}