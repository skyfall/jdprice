<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_index".
 *
 * @property int $id
 * @property int $aid
 * @property string $aidurl
 * @property string $title
 * @property string $pic
 * @property int $displayorder
 */
class NewsIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'aid', 'aidurl', 'title', 'pic', 'displayorder'], 'required'],
            [['id', 'aid', 'displayorder'], 'integer'],
            [['aidurl'], 'string', 'max' => 2000],
            [['title'], 'string', 'max' => 3000],
            [['pic'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'aidurl' => 'Aidurl',
            'title' => 'Title',
            'pic' => 'Pic',
            'displayorder' => 'Displayorder',
        ];
    }
}
