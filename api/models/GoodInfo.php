<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "good_info".
 *
 * @property int $id
 * @property string $goodId 商品唯一id  例如京东商品  jd_1111
 * @property int $update_at 更新时间
 * @property int $create_at 创建时间
 * @property string $good_seller 商品平台 京东使用jd
 * @property string $good_inf_arr 商品的其他信息
 */
class GoodInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodId', 'update_at', 'create_at', 'good_seller'], 'required'],
            [['update_at', 'create_at'], 'integer'],
            [['good_inf_arr'], 'string'],
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
            'update_at' => 'Update At',
            'create_at' => 'Create At',
            'good_seller' => 'Good Seller',
            'good_inf_arr' => 'Good Inf Arr',
        ];
    }
}
