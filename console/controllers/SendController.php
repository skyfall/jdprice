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
                if ($NewsCategoryInf = \console\newdb\NewsCategory::find()->where(['cid' => $NewsCategory->cid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsCategoryInf = new \console\newdb\NewsCategory();

                $NewsCategoryInf->load($NewsCategory->getAttributes(),'');
                if ($NewsCategoryInf->save()){
//                    echo  "写入成功 aid.".$NewsCategoryModel->cid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsCategoryInf->errors)." id:{$NewsCategoryInf->cid}\r\n";
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
                if ($NewsCommentModelInf = \console\newdb\NewsComment::find()->where(['id' => $NewsComment->id])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsCommentModelInf = new \console\newdb\NewsComment();

                $NewsCommentModelInf->load($NewsComment->getAttributes(),'');
                if ($NewsCommentModelInf->save()){
//                    echo  "写入成功 id.".$NewsCommentModel->id."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsCommentModelInf->errors)." id:{$NewsCommentModelInf->aid}\r\n";
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
                if ($NewsDateModelInf = \console\newdb\NewsDate::find()->where(['aid' => $NewsDate->aid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsDateModelInf = new \console\newdb\NewsDate();

                $NewsDateModelInf->load($NewsDate->getAttributes(),'');
                if ($NewsDateModelInf->save()){
//                    echo  "写入成功 aid.".$NewsDateModel->aid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsDateModelInf->errors)." id:{$NewsDateModelInf->aid}\r\n";
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
                if ($NewsHeadnewsModelInf = \console\newdb\NewsHeadnews::find()->where(['id' => $NewsHeadnews->id])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsHeadnewsModelInf = new \console\newdb\NewsHeadnews();

                $NewsHeadnewsModelInf->load($NewsHeadnews->getAttributes(),'');
                if ($NewsHeadnewsModelInf->save()){
//                    echo  "写入成功 aid.".$NewsHeadnewsModel->id."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsHeadnewsModelInf->errors)." id:{$NewsHeadnewsModelInf->id}\r\n";
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
                if ($NewsTopicModelInf = \console\newdb\NewsTopic::find()->where(['tid' => $NewsTopic->tid])->one()){
//                    echo "数据存在\r\n";
                    continue;
                }
                $NewsTopicModelInf = new \console\newdb\NewsTopic();

                $NewsTopicModelInf->load($NewsTopic->getAttributes(),'');
                if ($NewsTopicModelInf->save()){
//                    echo  "写入成功 aid.".$NewsTopicModel->tid."\r\n";
                }else{
                    echo "写尔失败 err:".json_encode($NewsTopicModelInf->errors)." id:{$NewsTopicModelInf->tid}\r\n";
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