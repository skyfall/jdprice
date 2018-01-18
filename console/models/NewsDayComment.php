<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_day_comment".
 *
 * @property int $days
 * @property int $coment
 * @property int $month
 * @property int $week
 */
class NewsDayComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_day_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['days', 'coment', 'month', 'week'], 'required'],
            [['days', 'coment', 'month', 'week'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'days' => 'Days',
            'coment' => 'Coment',
            'month' => 'Month',
            'week' => 'Week',
        ];
    }
}
