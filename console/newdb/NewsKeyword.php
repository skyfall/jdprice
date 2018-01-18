<?php

namespace console\newdb;

use Yii;

/**
 * This is the model class for table "news_keyword".
 *
 * @property int $aid
 * @property string $keyword
 */
class NewsKeyword extends \yii\db\ActiveRecord
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
        return 'news_keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid'], 'required'],
            [['aid'], 'integer'],
            [['keyword'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'keyword' => 'Keyword',
        ];
    }
}
