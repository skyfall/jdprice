<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_headnews".
 *
 * @property int $id
 * @property string $newurl
 * @property string $title
 * @property int $color
 * @property int $bold
 * @property int $aid
 * @property int $displayorder
 */
class NewsHeadnews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_headnews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newurl', 'title', 'color', 'bold', 'aid', 'displayorder'], 'required'],
            [['color', 'bold', 'aid', 'displayorder'], 'integer'],
            [['newurl'], 'string', 'max' => 2000],
            [['title'], 'string', 'max' => 3000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'newurl' => 'Newurl',
            'title' => 'Title',
            'color' => 'Color',
            'bold' => 'Bold',
            'aid' => 'Aid',
            'displayorder' => 'Displayorder',
        ];
    }
}
