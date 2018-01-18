<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "news_article".
 *
 * @property int $aid
 * @property int $cid
 * @property int $uid
 * @property string $username
 * @property string $title
 * @property string $fromurl
 * @property string $froms
 * @property string $translate
 * @property string $editor
 * @property string $pic
 * @property string $description
 * @property int $pubdate
 * @property int $delstate 1删除2临时
 * @property int $recom
 * @property int $headline
 * @property int $lighten
 * @property string $headpic
 * @property int $favorite
 * @property int $shares
 * @property int $comments
 * @property int $good
 * @property int $bad
 * @property int $tid
 * @property string $videopic
 * @property string $youtube
 * @property string $v_qq
 * @property string $youku
 * @property string $iqiyi
 * @property string $fenghuang
 * @property string $tourl
 * @property int $type_1
 * @property int $type_2
 * @property int $type_3
 * @property int $type_4
 * @property int $bancom
 * @property int $essence
 * @property int $ads
 * @property string $searchkeyword
 */
class NewsArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'uid', 'username', 'title', 'fromurl', 'froms', 'translate', 'editor', 'pic', 'description', 'pubdate', 'delstate', 'recom', 'headline', 'lighten', 'headpic', 'favorite', 'shares', 'comments', 'good', 'bad', 'tid', 'videopic', 'youtube', 'v_qq', 'youku', 'iqiyi', 'fenghuang', 'tourl', 'type_1', 'type_2', 'type_3', 'type_4', 'bancom', 'essence', 'ads', 'searchkeyword'], 'required'],
            [['cid', 'uid', 'pubdate', 'delstate', 'recom', 'headline', 'lighten', 'favorite', 'shares', 'comments', 'good', 'bad', 'tid', 'type_1', 'type_2', 'type_3', 'type_4', 'bancom', 'essence', 'ads'], 'integer'],
            [['description', 'tourl'], 'string'],
            [['username'], 'string', 'max' => 40],
            [['title', 'pic', 'headpic', 'videopic', 'searchkeyword'], 'string', 'max' => 100],
            [['fromurl', 'youtube', 'v_qq', 'youku', 'iqiyi', 'fenghuang'], 'string', 'max' => 1000],
            [['froms'], 'string', 'max' => 60],
            [['translate', 'editor'], 'string', 'max' => 40],
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
            'uid' => 'Uid',
            'username' => 'Username',
            'title' => 'Title',
            'fromurl' => 'Fromurl',
            'froms' => 'Froms',
            'translate' => 'Translate',
            'editor' => 'Editor',
            'pic' => 'Pic',
            'description' => 'Description',
            'pubdate' => 'Pubdate',
            'delstate' => 'Delstate',
            'recom' => 'Recom',
            'headline' => 'Headline',
            'lighten' => 'Lighten',
            'headpic' => 'Headpic',
            'favorite' => 'Favorite',
            'shares' => 'Shares',
            'comments' => 'Comments',
            'good' => 'Good',
            'bad' => 'Bad',
            'tid' => 'Tid',
            'videopic' => 'Videopic',
            'youtube' => 'Youtube',
            'v_qq' => 'V Qq',
            'youku' => 'Youku',
            'iqiyi' => 'Iqiyi',
            'fenghuang' => 'Fenghuang',
            'tourl' => 'Tourl',
            'type_1' => 'Type 1',
            'type_2' => 'Type 2',
            'type_3' => 'Type 3',
            'type_4' => 'Type 4',
            'bancom' => 'Bancom',
            'essence' => 'Essence',
            'ads' => 'Ads',
            'searchkeyword' => 'Searchkeyword',
        ];
    }
}
