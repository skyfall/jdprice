<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "weixin_user".
 *
 * @property int $id
 * @property string $app_id 公众号的appid
 * @property string $openid 用户的微信号
 * @property int $subscribe 用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
 * @property int $creaate_at 创建时间
 * @property int $update_at 更新时间
 * @property string $nickname 用户的昵称
 * @property int $subscribe_time 用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
 * @property int $sex 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
 * @property string $city 用户所在城市
 * @property string $country 用户所在国家
 * @property string $province 用户所在省份
 * @property string $language 用户的语言，简体中文为zh_CN
 * @property string $headimgurl 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
 * @property string $unionid 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
 * @property string $remark 公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注
 * @property string $groupid 用户所在的分组ID（兼容旧的用户分组接口）
 * @property string $tagid_list 用户被打上的标签ID列表
 */
class WeixinUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weixin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'openid', 'subscribe', 'creaate_at', 'update_at'], 'required'],
            [['subscribe', 'creaate_at', 'update_at', 'subscribe_time', 'sex'], 'integer'],
            [['headimgurl', 'remark', 'tagid_list'], 'string'],
            [['app_id'], 'string', 'max' => 20],
            [['openid', 'nickname', 'city', 'country', 'province', 'language', 'unionid', 'groupid'], 'string', 'max' => 45],
            [['openid'], 'unique'],
        ];
    }

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
            'update_at' => 'Update At',
            'nickname' => 'Nickname',
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
