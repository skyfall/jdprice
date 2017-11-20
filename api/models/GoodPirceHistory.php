<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "good_pirce_history".
 *
 * @property int $id
 * @property string $goodId 商品唯一id  例如京东商品  jd_1111
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property string $good_seller 商品平台 京东使用jd
 * @property string $good_history_arr 商品的历史价格信息
 */
class GoodPirceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_pirce_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodId', 'create_at', 'update_at', 'good_seller', 'good_history_arr'], 'required'],
            [['create_at', 'update_at'], 'integer'],
            [['good_history_arr'], 'string'],
            [['goodId', 'good_seller'], 'string', 'max' => 45],
            [['goodId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goodId' => 'Good ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'good_seller' => 'Good Seller',
            'good_history_arr' => 'Good History Arr',
        ];
    }
}
