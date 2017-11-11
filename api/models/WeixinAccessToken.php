<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "weixin_access_token".
 *
 * @property int $id
 * @property string $app_id 公众号的appid
 * @property string $access_token 微信调用令牌
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 */
class WeixinAccessToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weixin_access_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'access_token', 'create_at', 'update_at'], 'required'],
            [['create_at', 'update_at'], 'integer'],
            [['app_id'], 'string', 'max' => 45],
            [['access_token'], 'string', 'max' => 255],
            [['app_id'], 'unique'],
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
            'access_token' => 'Access Token',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
