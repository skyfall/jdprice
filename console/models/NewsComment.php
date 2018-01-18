<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_comment".
 *
 * @property int $id
 * @property int $aid
 * @property int $userid
 * @property string $username
 * @property string $content
 * @property int $rootid
 * @property int $replyid
 * @property int $addtime
 * @property int $up
 * @property int $down
 * @property int $state
 * @property string $ipdress
 * @property string $address 发帖人地址
 * @property int $commnum
 * @property int $del_status 删除状态 默认0 删除1
 * @property int $report_status
 * @property string $report_con
 * @property string $deler
 */
class NewsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'userid', 'username', 'content', 'rootid', 'replyid', 'addtime', 'up', 'down', 'state', 'ipdress', 'address', 'commnum', 'report_status', 'report_con', 'deler'], 'required'],
            [['aid', 'userid', 'rootid', 'replyid', 'addtime', 'up', 'down', 'state', 'commnum', 'del_status', 'report_status'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['content'], 'string', 'max' => 1500],
            [['ipdress'], 'string', 'max' => 39],
            [['address'], 'string', 'max' => 100],
            [['report_con'], 'string', 'max' => 300],
            [['deler'], 'string', 'max' => 60],
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
            'userid' => 'Userid',
            'username' => 'Username',
            'content' => 'Content',
            'rootid' => 'Rootid',
            'replyid' => 'Replyid',
            'addtime' => 'Addtime',
            'up' => 'Up',
            'down' => 'Down',
            'state' => 'State',
            'ipdress' => 'Ipdress',
            'address' => 'Address',
            'commnum' => 'Commnum',
            'del_status' => 'Del Status',
            'report_status' => 'Report Status',
            'report_con' => 'Report Con',
            'deler' => 'Deler',
        ];
    }
}
