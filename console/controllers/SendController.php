<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2018/1/17
 * Time: 下午10:25
 */

namespace console\controllers;

use console\models\NewsArticle;
use console\models\NewsCategory;
use console\models\NewsComment;
use console\models\NewsDate;
use console\models\NewsHeadnews;
use console\models\NewsTopic;
use console\models\TopicList;
use console\models\NewsDayComment;
use console\models\TopicContentList;
use yii\console\Controller;

class SendController extends Controller
{
    public function actionNewsarticle($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NewsArticleModel  = NewsArticle::find()->where(['>=','aid',$id]);

        while ($NewsArticles = $NewsArticleModel->offset($offset)->limit($limit)->orderBy('aid asc')->all()){
            $offset += $limit;
            /**
             * @var NewsArticle $NewsArticle
             */
            foreach ($NewsArticles as $NewsArticle){
                if ($newdbNewsArticleModel = \console\newdb\NewsArticle::find()->where(['aid' => $NewsArticle->aid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $newdbNewsArticleModel = new \console\newdb\NewsArticle();
                $newdbNewsArticleModel->load($NewsArticle->getAttributes(),'');
                if ($newdbNewsArticleModel->save()){
//                    echo  "写入成功 aid.".$NewsArticle->aid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($newdbNewsArticleModel->errors)." id:{$NewsArticle->aid}\r\n";
                }
            }
        }
    }


    public function actionNewscategory($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NewsCategoryModel  = NewsCategory::find()->where(['>=','cid',$id]);

        while ($NewsCategorys = $NewsCategoryModel->offset($offset)->limit($limit)->orderBy('cid asc')->all()){
            $offset += $limit;
            /**
             * @var NewsCategory $NewsCategory
             */
            foreach ($NewsCategorys as $NewsCategory){
                if ($NewsCategoryModel = \console\newdb\NewsCategory::find()->where(['cid' => $NewsCategory->cid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsCategoryModel = new \console\newdb\NewsCategory();

                $NewsCategoryModel->load($NewsCategory->getAttributes(),'');
                if ($NewsCategoryModel->save()){
//                    echo  "写入成功 aid.".$NewsCategoryModel->cid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsCategory->errors)." id:{$NewsCategory->cid}\r\n";
                }
            }
        }
    }

    public function actionNewscomment($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NewsCommentModel  = NewsComment::find()->where(['>=','id',$id]);

        while ($NewsComments = $NewsCommentModel->offset($offset)->limit($limit)->orderBy('id asc')->all()){
            $offset += $limit;
            /**
             * @var NewsComment $NewsComment
             */
            foreach ($NewsComments as $NewsComment){
                if ($NewsCommentModel = \console\newdb\NewsComment::find()->where(['id' => $NewsComment->id])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsCommentModel = new \console\newdb\NewsComment();

                $NewsCommentModel->load($NewsComment->getAttributes(),'');
                if ($NewsCommentModel->save()){
//                    echo  "写入成功 id.".$NewsCommentModel->id."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsCommentModel->errors)." id:{$NewsCommentModel->aid}\r\n";
                }
            }
        }
    }

    public function actionNewsdata($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NewsDateModel  = NewsDate::find()->where(['>=','aid',$id]);

        while ($NewsDates = $NewsDateModel->offset($offset)->limit($limit)->orderBy('aid asc')->all()){
            $offset += $limit;
            /**
             * @var NewsDate $NewsDate
             */
            foreach ($NewsDates as $NewsDate){
                if ($NewsDateModel = \console\newdb\NewsDate::find()->where(['aid' => $NewsDate->aid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsDateModel = new \console\newdb\NewsDate();

                $NewsDateModel->load($NewsDate->getAttributes(),'');
                if ($NewsDateModel->save()){
//                    echo  "写入成功 aid.".$NewsDateModel->aid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsDate->errors)." id:{$NewsDate->aid}\r\n";
                }
            }
        }
    }

//    public function actionNewsdaycomment(){
//        $limit = 100 ;
//        $offset = 0;
//        $NewsDayCommentModel  = NewsDayComment::find();
//
//        while ($NewsDayComments = $NewsDayCommentModel->offset($offset)->limit($limit)->orderBy('aid asc')->all()){
//            /**
//             * @var NewsDayComment $NewsDayComment
//             */
//            foreach ($NewsDayComments as $NewsDayComment){
//                if ($NewsDayCommentModel = \console\newdb\NewsDayComment::find()->where(['aid' => $NewsDayComment->days])->one()){
//                    echo "数据存在\r\n";
//                    continue;
//                }
//                $NewsDayCommentModel = new \console\newdb\NewsDayComment();
//
//                $NewsDayCommentModel->load($NewsDayComment->getAttributes(),'');
//                if ($NewsDayCommentModel->save()){
//                    echo  "写入成功 aid.".$NewsDayCommentModel->aid."\r\n";
//                }else{
//                    echo "希尔失败 err:".json_encode($NewsDayCommentModel->errors)."\r\n";
//                }
//            }
//        }
//    }


    public function actionNewsheadnews($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NewsHeadnewsModel  = NewsHeadnews::find()->where(['>=','id',$id]);

        while ($NewsHeadnewss = $NewsHeadnewsModel->offset($offset)->limit($limit)->orderBy('id asc')->all()){
            $offset += $limit;
            /**
             * @var NewsHeadnews $NewsHeadnews
             */
            foreach ($NewsHeadnewss as $NewsHeadnews){
                if ($NewsHeadnewsModel = \console\newdb\NewsHeadnews::find()->where(['id' => $NewsHeadnews->id])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsHeadnewsModel = new \console\newdb\NewsHeadnews();

                $NewsHeadnewsModel->load($NewsHeadnews->getAttributes(),'');
                if ($NewsHeadnewsModel->save()){
//                    echo  "写入成功 aid.".$NewsHeadnewsModel->id."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsHeadnewsModel->errors)." id:{$NewsHeadnewsModel->id}\r\n";
                }
            }
        }
    }

    public function actionNewstopic(){
        $limit = 100 ;
        $offset = 0;
        $NewsTopicModel  = NewsTopic::find($id = 1)->where(['>=','tid',$id]);

        while ($NewsTopics = $NewsTopicModel->offset($offset)->limit($limit)->orderBy('tid asc')->all()){
            $offset += $limit;
            /**
             * @var NewsTopic $NewsTopic
             */
            foreach ($NewsTopics as $NewsTopic){
                if ($NewsTopicModel = \console\newdb\NewsTopic::find()->where(['tid' => $NewsTopic->tid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsTopicModel = new \console\newdb\NewsTopic();

                $NewsTopicModel->load($NewsTopic->getAttributes(),'');
                if ($NewsTopicModel->save()){
//                    echo  "写入成功 aid.".$NewsTopicModel->tid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsTopic->errors)." id:{$NewsTopic->tid}\r\n";
                }
            }
        }
    }


    public function actionTopiccontentlist($id = 1){
        $limit = 100 ;
        $offset = 0;
        $NTopicContentListModel  = TopicContentList::find()->where(['>=','cid',$id]);

        while ($TopicContentLists = $NTopicContentListModel->offset($offset)->limit($limit)->orderBy('cid asc')->all()){
            $offset += $limit;
            /**
             * @var TopicContentList $TopicContentList
             */
            foreach ($TopicContentLists as $TopicContentList){
                if ($TopicContentListModel = \console\newdb\TopicContentList::find()->where(['cid' => $TopicContentList->cid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $TopicContentListModel = new \console\newdb\TopicContentList();

                $TopicContentListModel->load($TopicContentList->getAttributes(),'');
                if ($TopicContentListModel->save()){
//                    echo  "写入成功 aid.".$TopicContentListModel->cid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($TopicContentListModel->errors)." id:{$TopicContentListModel->cid}\r\n";
                }
            }
        }
    }


    public function actionTopiclist($id = 1){
        $limit = 100 ;
        $offset = 0;
        $TopicListModel  = TopicList::find()->where(['>=','topic_id',$id]);

        while ($TopicListModels = $TopicListModel->offset($offset)->limit($limit)->orderBy('topic_id asc')->all()){
            $offset += $limit;
            /**
             * @var TopicList $TopicListModel
             */
            foreach ($TopicListModels as $TopicListModel){
                if ($TopicList = \console\newdb\TopicList::find()->where(['topic_id' => $TopicListModel->topic_id])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $TopicList = new \console\newdb\TopicList();

                $TopicList->load($TopicListModel->getAttributes(),'');
                if ($TopicList->save()){
//                    echo  "写入成功 aid.".$TopicList->topic_id."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($TopicList->errors)." id:{$TopicList->topic_id}\r\n";
                }
            }
        }
    }




}