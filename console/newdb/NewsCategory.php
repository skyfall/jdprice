<?php

namespace console\newdb;

use Yii;

/**
 * This is the model class for table "news_category".
 *
 * @property int $cid
 * @property int $upuid
 * @property string $catname
 * @property int $articles
 * @property string $displayorder
 */
class NewsCategory extends \yii\db\ActiveRecord
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
        return 'news_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid'], 'required'],
            [['upuid', 'articles'], 'integer'],
            [['catname', 'displayorder'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'upuid' => 'Upuid',
            'catname' => 'Catname',
            'articles' => 'Articles',
            'displayorder' => 'Displayorder',
        ];
    }
}
