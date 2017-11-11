<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "good_price_log".
 *
 * @property int $id
 * @property string $good_seller 商品平台 京东使用jd
 * @property string $goodId 商品唯一id  例如京东商品  jd_1111
 * @property int $create_at 创建时间
 * @property int $price 价格 单位分
 * @property string $title 商品名称
 */
class GoodPriceLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_price_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_seller', 'goodId', 'create_at', 'price', 'title'], 'required'],
            [['create_at', 'price'], 'integer'],
            [['title'], 'string'],
            [['good_seller', 'goodId'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_seller' => 'Good Seller',
            'goodId' => 'Good ID',
            'create_at' => 'Create At',
            'price' => 'Price',
            'title' => 'Title',
        ];
    }
}
