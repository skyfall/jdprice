<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "topic_content_list".
 *
 * @property int $cid
 * @property int $topic_id
 * @property string $c_title
 * @property int $c_index
 * @property int $c_type
 * @property int $c_tid
 * @property int $c_aid
 * @property string $c_imgstr
 * @property string $c_url
 * @property int $status 1删除
 */
class TopicContentList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic_content_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'c_title', 'c_index', 'c_type', 'c_tid', 'c_aid', 'c_imgstr', 'c_url', 'status'], 'required'],
            [['topic_id', 'c_index', 'c_type', 'c_tid', 'c_aid', 'status'], 'integer'],
            [['c_imgstr'], 'string'],
            [['c_title'], 'string', 'max' => 300],
            [['c_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'topic_id' => 'Topic ID',
            'c_title' => 'C Title',
            'c_index' => 'C Index',
            'c_type' => 'C Type',
            'c_tid' => 'C Tid',
            'c_aid' => 'C Aid',
            'c_imgstr' => 'C Imgstr',
            'c_url' => 'C Url',
            'status' => 'Status',
        ];
    }
}
