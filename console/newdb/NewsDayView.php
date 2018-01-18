<?php

namespace console\newdb;

use Yii;

/**
 * This is the model class for table "news_day_view".
 *
 * @property int $days
 * @property int $type1
 * @property int $type2
 * @property int $month
 * @property int $week
 * @property int $type3
 */
class NewsDayView extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('newdb');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_day_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['days', 'type1', 'type2', 'month', 'week', 'type3'], 'required'],
            [['days', 'type1', 'type2', 'month', 'week', 'type3'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'days' => 'Days',
            'type1' => 'Type1',
            'type2' => 'Type2',
            'month' => 'Month',
            'week' => 'Week',
            'type3' => 'Type3',
        ];
    }
}
