<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/11
 * Time: 下午11:31
 */

namespace api\controllers;


use api\models\WeixinMsgTypeCount;
use yii\base\Object;

class WeixinDataController extends Object
{

    /**
     * 添加公众号的统计消息类型数据
     * @param $appid            公众号appid
     * @param $mesTpye          消息类型字符串
     * @param array $errArr     错误性新
     * @return bool
     */
    public function addMegTypeCount($appid,$msgTpye,array  &$errArr){
        //转换小写  前后去空
        $msgTpye = trim(strtolower($msgTpye));
        $time = mktime(date('H'),0,0,date('m'),date('d'),date('Y'));
        $msgTpyeModel = WeixinMsgTypeCount::findOne(['app_id'=>$appid,'time_hours'=>$time,'msg_type'=>$msgTpye]);
        if (empty($msgTpyeModel)){
            $msgTpyeModel = new WeixinMsgTypeCount();
            $msgTpyeModel->app_id = $appid;
            $msgTpyeModel->time_hours = $time;
            $msgTpyeModel->msg_type = $msgTpye;
            $msgTpyeModel->create_at = time();
            $msgTpyeModel->update_at = time();
            $msgTpyeModel->count = 0;
            if (!$msgTpyeModel->save()){
                $errArr['addMegTypeCount'][] = '添加失败 appid:'.$appid.' mesType:'.$msgTpye.' res:'.json_encode($msgTpyeModel->errors,JSON_UNESCAPED_SLASHES);
                return false;
            }
        }

        $upTime = time()- $msgTpyeModel->update_at;
        $resBool = WeixinMsgTypeCount::updateAllCounters(['count' => 1,'update_at'=>$upTime],'id=:id',[':id'=>$msgTpyeModel->id]);
        if (!$resBool){
            $errArr['addMegTypeCount'][] = '更新失败 appid:'.$appid.' mesType:'.$msgTpye;
            return false;
        }
        return true;
    }
}