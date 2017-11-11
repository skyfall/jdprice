<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "good_price".
 *
 * @property int $id
 * @property string $goodId 商品唯一id  例如京东商品  jd_1111
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property string $good_seller 商品平台 京东使用jd
 * @property int $price 商品价格  单位分
 * @property string $title 商品名称
 */
class GoodPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodId', 'create_at', 'update_at', 'good_seller', 'price', 'title'], 'required'],
            [['create_at', 'update_at', 'price'], 'integer'],
            [['title'], 'string'],
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
            'price' => 'Price',
            'title' => 'Title',
        ];
    }
}
