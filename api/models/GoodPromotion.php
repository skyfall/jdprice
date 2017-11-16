<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "good_promotion".
 *
 * @property int $id
 * @property string $goodId 商品的id 例如京东 jd_111
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property string $good_inf_arr 商品的优惠信息json字符串
 * @property string $good_seller 商品平台 京东使用jd
 */
class GoodPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodId', 'create_at', 'update_at', 'good_inf_arr', 'good_seller'], 'required'],
            [['create_at', 'update_at'], 'integer'],
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
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'good_inf_arr' => 'Good Inf Arr',
            'good_seller' => 'Good Seller',
        ];
    }
}
