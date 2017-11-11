<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "weixin_msg_type_count".
 *
 * @property int $id
 * @property string $app_id 公众号的appid
 * @property int $time_hours 每个小时的整点的时间戳
 * @property string $msg_type 类型的字符串名称
 * @property int $count 出发的次数
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 */
class WeixinMsgTypeCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weixin_msg_type_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'time_hours', 'msg_type', 'count', 'create_at', 'update_at'], 'required'],
            [['time_hours', 'count', 'create_at', 'update_at'], 'integer'],
            [['app_id'], 'string', 'max' => 20],
            [['msg_type'], 'string', 'max' => 45],
            [['app_id', 'time_hours', 'msg_type'], 'unique'],
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
            'time_hours' => 'Time Hours',
            'msg_type' => 'Msg Type',
            'count' => 'Count',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
