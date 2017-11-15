<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/13
 * Time: 下午11:09
 */

namespace api\modelsfrom;


use yii\base\Model;


/**
 * Class JdGoodInfFrom
 * @package api\modelsfrom
 * @property string $modules
 * @property string $imageAndVideoJson
 * @property string $skuid
 * @property string $name
 * @property string $skuidkey
 * @property string $href
 * @property string $src
 * @property string $imageList
 * @property string $cat
 * @property string $forceAdUpdate
 * @property string $brand
 * @property string $pType
 * @property string $isClosePCShow
 * @property string $pTag
 * @property string $isPop
 * @property string $venderId
 * @property string $shopId
 * @property string $specialAttrs
 * @property string $recommend
 * @property string $easyBuyUrl
 * @property string $qualityLife
 * @property string $colorSize
 * @property string $warestatus
 * @property string $desc
 * @property string $twoColumn
 * @property string $ctCloth
 * @property string $isCloseLoop
 * @property string $isBookMvd4Baby
 * @property string $addComments
 * @property string $mainSkuId
 * @property string $foot
 * @property string $shangjiazizhi
 */
class JdGoodInfFrom extends Model
{

    public $compatible;
    public $modules=[];
    public $imageAndVideoJson='';
    public $skuid=0;
    public $name='';
    public $skuidkey='';
    public $href='';
    public $src='';
    public $imageList=[];
    public $cat=[];
    public $forceAdUpdate='';
    public $brand=0;
    public $pType=0;
    public $isClosePCShow=false;
    public $pTag=0;
    public $isPop=false;
    public $venderId=0;
    public $shopId=0;
    public $specialAttrs=[];
    public $recommend=[];
    public $easyBuyUrl='';
    public $qualityLife='';
    public $colorSize=[];
    public $warestatus='';
    public $desc='';
    public $twoColumn=false;
    public $ctCloth=false;
    public $isCloseLoop=false;
    public $isBookMvd4Baby=false;
    public $addComments=false;
    public $mainSkuId='';
    public $foot='';
    public $shangjiazizhi=false;

//    /**
//     * @inheritdoc
//     */
    public function rules()
    {
        return [
            // username and password are both required
            [['skuid', 'name'], 'required'],
            [['isClosePCShow','twoColumn','ctCloth','isCloseLoop','isBookMvd4Baby','addComments','shangjiazizhi'], 'default', 'value' => false],
            [['isClosePCShow','twoColumn','ctCloth','isCloseLoop','isBookMvd4Baby','addComments','shangjiazizhi'], 'boolean'],
            [
                [
                    'compatible','modules','imageAndVideoJson','skuid','skuidkey','href','src','imageList','cat','forceAdUpdate',
                    'brand','pType','isClosePCShow','pTag','isPop','venderId','shopId','specialAttrs','recommend','easyBuyUrl',
                    'qualityLife','colorSize','warestatus','desc','twoColumn','ctCloth','isCloseLoop','isBookMvd4Baby','isBookMvd4Baby','addComments',
                    'mainSkuId','foot','shangjiazizhi'
                ],
                'trim'],
        ];
    }

    public function attributeLabels(){
        return [
            "compatible"=>"",
            "modules"=>"",
            "imageAndVideoJson"=>"",
            "skuid"=>"",
            "name"=>"",
            "skuidkey"=>"",
            "href"=>"",
            "src"=>"",
            "imageList"=>"",
            "cat"=>"",
            "forceAdUpdate"=>"",

            "brand"=>"",
            "pType"=>"",
            "isClosePCShow"=>"",
            "pTag"=>"",
            "isPop"=>"",
            "venderId"=>"",
            "shopId"=>"",
            "specialAttrs"=>"",
            "recommend"=>"",
            "easyBuyUrl"=>"",

            "qualityLife"=>"",
            "colorSize"=>"",
            "warestatus"=>"",
            "desc"=>"",
            "twoColumn"=>"",
            "ctCloth"=>"",
            "isCloseLoop"=>"",
            "isBookMvd4Baby"=>"",
            "addComments"=>"",

            "mainSkuId"=>"",
            "foot"=>"",
            "shangjiazizhi"=>"",
        ];
    }


}