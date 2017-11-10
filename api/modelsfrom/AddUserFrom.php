<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/10
 * Time: 下午6:10
 */

namespace api\modelsfrom;


use yii\base\Model;


class AddUserFrom extends Model
{
    public $app_id;
    
    public $openid;

    public $subscribe;

    public $nickname;

    public $subscribe_time;

    public $sex;

    public $city;

    public $country;

    public $province;

    public $language;

    public $headimgurl;

    public $unionid;

    public $remark;

    public $groupid;

    public $tagid_list;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'openid' => 'Openid',
            'subscribe' => 'Subscribe',
            'creaate_at' => 'Creaate At',
            'nickname' => 'Nickname',
            'update_at' => 'Update At',
            'subscribe_time' => 'Subscribe Time',
            'sex' => 'Sex',
            'city' => 'City',
            'country' => 'Country',
            'province' => 'Province',
            'language' => 'Language',
            'headimgurl' => 'Headimgurl',
            'unionid' => 'Unionid',
            'remark' => 'Remark',
            'groupid' => 'Groupid',
            'tagid_list' => 'Tagid List',
        ];
    }

}