<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_topic".
 *
 * @property int $tid
 * @property string $topicname
 */
class NewsTopic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topicname'], 'required'],
            [['topicname'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'Tid',
            'topicname' => 'Topicname',
        ];
    }
}
