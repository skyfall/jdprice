<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_keyword".
 *
 * @property int $aid
 * @property string $keyword
 */
class NewsKeyword extends \yii\db\ActiveRecord
{
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
            [['aid', 'keyword'], 'required'],
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
