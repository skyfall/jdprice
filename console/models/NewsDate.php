<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_date".
 *
 * @property int $aid
 * @property int $cid
 * @property string $title
 * @property string $content
 */
class NewsDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'cid', 'title', 'content'], 'required'],
            [['aid', 'cid'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 60],
            [['aid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'cid' => 'Cid',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }
}
