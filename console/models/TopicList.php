<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "topic_list".
 *
 * @property int $topic_id
 * @property int $total_nums 该话题的文章数
 * @property string $topic_name
 * @property string $topic_content
 * @property string $hot_pic
 * @property string $pic1
 * @property string $pic2
 * @property string $pic3
 * @property int $isHot
 * @property int $fid
 * @property int $typeid
 * @property int $del_status 1删除
 * @property int $priority 话题排序权重
 */
class TopicList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_nums', 'isHot', 'fid', 'typeid', 'del_status', 'priority'], 'integer'],
            [['topic_name', 'topic_content', 'hot_pic', 'pic1', 'pic2', 'pic3', 'fid', 'typeid', 'del_status'], 'required'],
            [['topic_content'], 'string'],
            [['topic_name', 'pic1', 'pic2', 'pic3'], 'string', 'max' => 150],
            [['hot_pic'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'topic_id' => 'Topic ID',
            'total_nums' => 'Total Nums',
            'topic_name' => 'Topic Name',
            'topic_content' => 'Topic Content',
            'hot_pic' => 'Hot Pic',
            'pic1' => 'Pic1',
            'pic2' => 'Pic2',
            'pic3' => 'Pic3',
            'isHot' => 'Is Hot',
            'fid' => 'Fid',
            'typeid' => 'Typeid',
            'del_status' => 'Del Status',
            'priority' => 'Priority',
        ];
    }
}
