<?php

namespace console\newdb;

use Yii;

/**
 * This is the model class for table "news_view".
 *
 * @property int $aid
 * @property int $viewnum
 * @property int $viewnum2 阅读数量  目前使用该字段
 */
class NewsView extends \yii\db\ActiveRecord
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
        return 'news_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid'], 'required'],
            [['aid', 'viewnum', 'viewnum2'], 'integer'],
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
            'viewnum' => 'Viewnum',
            'viewnum2' => 'Viewnum2',
        ];
    }
}
