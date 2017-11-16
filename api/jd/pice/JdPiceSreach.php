<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/12
 * Time: 上午1:20
 */

namespace api\jd\pice;


use api\models\GoodInfo;
use api\models\GoodPrice;
use api\models\GoodPriceLog;
use api\models\GoodPromotion;
use api\modelsfrom\JdGoodInfFrom;
use api\modelsfrom\JdPromotionFrom;
use yii\base\Object;

class JdPiceSreach extends Object
{
    public static $curl;

    public static $curlHtmlDom = [];

    public $debugArr = [];

    public function init(){
        if (empty(self::$curl)){
            self::$curl = curl_init();
        }
    }

    public $sellType = "jd";

    /**
     * 带缓存 获取商品价格信息
     * @param $itemId
     * @param $errArr
     */
    public function getPriceStrage($itemId,&$price,&$title,&$errArr){
        //查找商品表中是否存在
        $goodId = "{$this->sellType}_{$itemId}";
        $GoodPrice = GoodPrice::findOne(['goodId'=>$goodId]);
        if (empty($GoodPrice)){
            $JdPiceModel = $this->getPice($itemId,$errArr);
            if (!$JdPiceModel){
                return false;
            }
            //获取商品标题
            if (!$mytitle = $this->getTitle($itemId,$errArr)){
                return false;
            }
            $GoodPrice = new GoodPrice();
            $GoodPrice->create_at = time();
            $GoodPrice->update_at = mktime(date("H"),0,0,date('m'),date('d'),date('Y'));
            $GoodPrice->price = ceil(($JdPiceModel->newprice)*100);
            $GoodPrice->goodId =$goodId;
            $GoodPrice->good_seller = $this->sellType;
            $GoodPrice->title = $mytitle;
            if (!$GoodPrice->save()){
                $errArr[] = $GoodPrice->errors;
            }else{
                $this->pricelogDb($goodId,$mytitle,$GoodPrice->price,$errArr);
            }
            $errArr[] = $GoodPrice->errors;
            $price =  $GoodPrice->price;
            $title = $mytitle;
            return true;
        }

        if (($GoodPrice->update_at) + 3600 <= time()){
            $JdPiceModel = $this->getPice($itemId,$errArr);
            if (!$JdPiceModel){
                return false;
            }
            //获取商品标题
            if (!$mytitle = $this->getTitle($itemId,$errArr)){
                return false;
            }

            $GoodPrice->title = $mytitle;
            $GoodPrice->price = ceil(($JdPiceModel->newprice)*100);
            $GoodPrice->update_at = time();
            if (!$GoodPrice->save()){
                $errArr[] = $GoodPrice->errors;
            }else{
                $this->pricelogDb($goodId,$mytitle,$GoodPrice->price,$errArr);
            }
            $errArr[] = $GoodPrice->errors;
            $price =  $GoodPrice->price;
            $title = $mytitle;
            return true;
        }


        $price =  $GoodPrice->price;
        $title = $GoodPrice->title;
        return true;
    }

    /**
     * 带缓存 查询商品信息
     * @param $itemId
     * @param $errArr
     * @return JdGoodInfFrom|bool
     */
    public function getGoodConfigStrage($itemId,&$errArr){

        //查找数据库是否存在数据
        $goodId = "{$this->sellType}_{$itemId}";
        if ($goodInf = GoodInfo::findOne(['goodId'=>$goodId])){
            if ($goodInf->update_at + \Yii::$app->params['goodConfigStarageTtl'] >= time()){
                $JdGoodInfFrom  = new JdGoodInfFrom();
                $JdGoodInfFrom->load(json_decode($goodInf->good_inf_arr,true),'');
                return $JdGoodInfFrom;
            }
        }else{
            $goodInf = new GoodInfo();
            $goodInf->create_at = time();
            $goodInf->goodId = $goodId;
            $goodInf->good_seller = $this->sellType;
        }


        //查询信息
        if (!$JdGoodInfFrom = $this->getGoodConfig($itemId,$errArr)){
            return false;
        }
        $goodInf->update_at = time();
        $goodInf->good_inf_arr = json_encode($JdGoodInfFrom->getAttributes());
        if (!$goodInf->save()){
            $errArr['getGoodConfigStrage'][] = '添加数据失败 res:'.json_encode($goodInf->errors);
        }
        return $JdGoodInfFrom;
    }

    public function getGoodPromotionStrage($itemId,&$errArr){
        //查找数据库是否存在数据
        $goodId = "{$this->sellType}_{$itemId}";
        if ($GoodPromotion = GoodPromotion::findOne(['goodId'=>$goodId])){
            if ($GoodPromotion->update_at + \Yii::$app->params['goodPromotionStarageTtl'] >= time()){
                $resArr = [];
                $GoodPromotionArr = json_decode($GoodPromotion->good_inf_arr,true);
                foreach ($GoodPromotionArr as $v){
                    $JdPromotionFrom  = new JdPromotionFrom();
                    $JdPromotionFrom->load($v,'');
                    $resArr[] = $JdPromotionFrom;
                }
                return $resArr;
            }
        }else{
            $GoodPromotion = new GoodPromotion();
            $GoodPromotion->create_at = time();
            $GoodPromotion->goodId = $goodId;
            $GoodPromotion->good_seller = $this->sellType;
        }

        //查询信息
        if (!$resArr = $this->getGoodPromotion($itemId,$errArr)){
            \Yii::error('查找jd商品促销信息失败 res:'.json_encode($errArr,JSON_UNESCAPED_UNICODE));
            return false;
        }
        $GoodPromotion->update_at = time();
        $DBarr = [];
        foreach ($resArr as $v){
            $DBarr[] = $v->getAttributes();
        }
        $GoodPromotion->good_inf_arr = json_encode($DBarr);
        if (!$GoodPromotion->save()){
            \Yii::error('保存商品jd商品促销信息失败 res:'.json_encode($GoodPromotion->errors,JSON_UNESCAPED_UNICODE));
            $errArr['getGoodPromotionStrage'][] = '添加数据失败 res:'.json_encode($GoodPromotion->errors);
        }
        return $resArr;


    }
    /**
     * 写入价格变动信息
     * @param $goodId
     * @param $mytitle
     * @param $price
     * @param $errArr
     * @return bool
     */
    private function pricelogDb($goodId,$mytitle,$price,&$errArr){
        //写入日志
        $GoodPriceLog = new GoodPriceLog();
        $GoodPriceLog->title = $mytitle;
        $GoodPriceLog->create_at = time();
        $GoodPriceLog->price = $price;
        $GoodPriceLog->good_seller = $this->sellType;
        $GoodPriceLog->goodId = $goodId;
        if (!$GoodPriceLog->save()){
            $errArr['pricelogDb'][] = $GoodPriceLog->errors;
            return false;
        }
    }


    /**
     * 查询京东商品价格
     * @param $itemId
     * @param $errArr
     * @return JdPiceModel
     */
    public function getPice($itemId,&$errArr){

        $randJQ = rand(1000000,9999999);
        $randAre = rand(1000,9999);
        $randUid = rand(10000000,99999999);
        $url = "https://p.3.cn/prices/mgets?callback=jQuery{$randJQ}&type=1&area=1_72_{$randAre}_0&pdtk=&pduid={$randUid}&pdpin=&pin=null&pdbp=0&skuIds=J_{$itemId}&ext=11000000&source=item-pc";

        $header = [
            'Accept: */*',
//            'Connection: keep-alive',
//            'Accept-Encoding: gzip, deflate, br',
            "Referer: https://item.jd.com/{$itemId}.html",
            'Accept-Language: zh-CN,zh;q=0.8',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
        ];
        curl_setopt(self::$curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$curl, CURLOPT_HEADER, 0);
        $output = curl_exec(self::$curl);
        // jQuery5745146([{"op":"8388.00","m":"9999.00","id":"J_5089235","p":"8388.00"}]);
        //查找返回值是否正常
        if (strpos($output,"jQuery{$randJQ}") === false){
            $errArr['getPice'][] = '查询商品失败 url:'.$url .' item:'.$itemId.' res:'.$output;
            return false;
        }
        $endJson = str_replace(["jQuery{$randJQ}(",");"],['',''],$output);
        //如果不是数组
        if (!$priceArr = json_decode($endJson,true)){
            $errArr['getPice'][] = '转换字符串失败 url:'.$url .' item:'.$itemId.' endJson:'.$endJson;
            return false;
        }

        if (!isset($priceArr[0]['p'])){
            $errArr['getPice'][] = '返回值找不到价格 url:'.$url .' item:'.$itemId.' json:'.json_encode($priceArr);
            return false;
        }
        $JdPiceModel = new JdPiceModel();
        $JdPiceModel->newprice = $priceArr[0]['p'];
        $JdPiceModel->oldPrice = isset($priceArr[0]['op']) ? $priceArr[0]['op'] : 0;
        $JdPiceModel->m = isset($priceArr[0]['m']) ? $priceArr[0]['m'] : 0 ;
        $JdPiceModel->id = isset($priceArr[0]['id']) ? $priceArr[0]['id'] : '';
        return $JdPiceModel;
    }

    /**
     * 获取商品名称
     * @param $itemId
     * @param $errArr
     * @return string|bool
     */
    public function getTitle($itemId,&$errArr){
        $JdGoodInfFrom = $this->getGoodConfigStrage($itemId,$errArr);
        if (!$JdGoodInfFrom){
            return false;
        }
        return $JdGoodInfFrom->name;
        // https://item.jd.com/16182548288.html
//        $url = "https://item.jd.com/{$itemId}.html";
//        $header = [
//            'Accept: */*',
////            'Connection: keep-alive',
////            'Accept-Encoding: gzip, deflate, br',
//            'Accept-Language: zh-CN,zh;q=0.8',
//            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
//        ];

//        $output = $this->getHtml($url,$header);
//
//
//        if (!$startIndex = strpos($output,'<title>')){
//            $errArr['getTitle'][] = '获取商品标题失败 url:'.$url;
//            return false;
//        }
////        var_dump($output);exit();
//
//        if (!$nextIndex = strpos($output,'</title>')){
//            $errArr['getTitle'][] = '获取商品尾巴标题标签失败 url:'.$url;
//            return false;
//        }
//
//        $length = $nextIndex - 7 - $startIndex ;
//        if ($title = substr($output,$startIndex+7,$length)){
//            $title = str_replace('</title>','',$title);
//            if ($myIndex = strpos($title,'【图片 价格 品牌 报价】')){
//                return substr($title,0,$myIndex);
//            }
//            if ($myIndex = strpos($title,'【行情 报价 价格 评测】')){
//                return substr($title,0,$myIndex);
//            }
//            return $title;
//        }
//        $errArr['getTitle'][] = '截取标题失败 url:'.$url;
//        return false;

    }

    /**
     * 获取京东商品的配置信息
     * @param $itemId
     * @param $errArr
     * @return JdGoodInfFrom|bool
     */
    public function getGoodConfig($itemId,&$errArr){
        // https://item.jd.com/16182548288.html
        $url = "https://item.jd.com/{$itemId}.html";
        $header = [
            'Accept: */*',
//            'Connection: keep-alive',
//            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: zh-CN,zh;q=0.8',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
        ];

        $output = $this->getHtml($url,$header);

        if (!$startIndex = strpos($output,'var pageConfig = {')){
            $errArr['getGoodConfig'][] = '找不到配置信息 url:'.$url;
            return false;
        }

        if (!$nextIndex = strpos($output,'};',$startIndex)){
            $errArr['getGoodConfig'][] = '找不到配置信息结尾信息失败 url:'.$url;
            return false;
        }
        $JdGoodInfFrom = new JdGoodInfFrom();
        $length = $nextIndex - 16 - $startIndex ;
        if ($pageConfig = substr($output,$startIndex+17,$length)){
            $pageConfig = preg_replace('# #','',$pageConfig);
            $JdGoodInfLable = $JdGoodInfFrom->attributeLabels();
            foreach ($JdGoodInfLable as $k=>$v){
                $configValue = $this->finxConfig($k,$pageConfig,$errArr);
                if (!$configValue){
                    continue;
                }
                if ($jsonStr = json_decode($configValue,true)){
                    $JdGoodInfLable[$k] = $jsonStr;
                }else {
                    $JdGoodInfLable[$k] = $this->unicode_decode($configValue);
                }
            }
            $JdGoodInfFrom->load($JdGoodInfLable,'');
            return $JdGoodInfFrom;

        }
        $errArr['getGoodConfig'][] = '截取配置信息失败 url:'.$url;
        return false;
    }

    /**
     * 获取商品优惠券信息
     * @param $itemId
     * @param $errArr
     * @return array|bool
     */
    public function getGoodPromotion($itemId,&$errArr){
        //带缓存的数据中获取商品的配置信息
        if (!$goodInfFrom = $this->getGoodConfigStrage($itemId,$errArr)){
            return false;
        }
        $rdJq = rand(1000000,9999999);
        $rdArear = rand(1000,9999);
        $cat = urlencode(implode(',',$goodInfFrom->cat));
        //url https://cd.jd.com/promotion/v2?callback=jQuery7302796&skuId=11075445&area=1_72_2799_0&shopId=1000011743&venderId=1000011743&cat=1713%2C3287%2C3800&isCanUseDQ=isCanUseDQ-1&isCanUseJQ=isCanUseJQ-1&_=1510759885402
        $url = "https://cd.jd.com/promotion/v2?callback=jQuery{$rdJq}&skuId={$goodInfFrom->skuid}&area=1_72_{$rdArear}_0&shopId={$goodInfFrom->shopId}&venderId={$goodInfFrom->venderId}&cat={$cat}&isCanUseDQ=isCanUseDQ-1&isCanUseJQ=isCanUseJQ-1&_=".time()*1000;
        $header = [
            'Accept: */*',
//            'Connection: keep-alive',
//            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: zh-CN,zh;q=0.8',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
        ];
        $resStr = $this->getHtml($url,$header);
        $index = strpos($resStr,"jQuery{$rdJq}(");
//        var_dump("jQuery{$rdJq}");
//        var_dump($resStr);exit();
        if ($index === false){
            $errArr['getGoodPromotion'][] = '请求获取优惠信息失败 url:'.$url;
            return false;
        }
        $json = substr($resStr,strlen("jQuery{$rdJq}("),strlen($resStr)-1-strlen("jQuery{$rdJq}("));
        if (!$promArr = json_decode($json,true)){
            $errArr['getGoodPromotion'][] = '装换数组失败 url:'.$url;
            return false;
        }

        if (!isset($promArr['skuCoupon']) || !is_array($promArr['skuCoupon'])){
            $errArr['getGoodPromotion'][] = '不存在优惠券数组信息 url:'.$url;
            return false;
        }

        $resArr = [];
        foreach ($promArr['skuCoupon'] as $v){
            $jdPromFrom = new JdPromotionFrom();
            $jdPromFrom->load($v,'');
            $resArr[] = $jdPromFrom;
        }
        return $resArr;
    }

    // 将UNICODE编码后的内容进行解码
    public function unicode_decode($name)
    {
        if(!$name) return $name;
        $decode = json_decode($name);
        if($decode) return $decode;
        $name = '["' . $name . '"]';
        $decode = json_decode($name);
        if(count($decode) == 1){
            return $decode[0];
        }
        return $name;

        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches))
        {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++)
            {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0)
                {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('UCS-2', 'UTF-8//IGNORE', $c);
                    $name .= $c;
                }
                else
                {
                    $name .= $str;
                }
            }
        }
        return $name;
    }

    /**
     * 解析京东网页配置文件方法
     * @param $configName
     * @param $configStr
     * @param $errArr
     * @return bool|mixed
     */
    public function finxConfig($configName,$configStr,&$errArr ){
        $str = $configName.":";
        $indexIndex = strpos($configStr,$str);
        if ($indexIndex === false){
            $errArr['finxConfig'] = '查找不到开始标签'.$str;
            return false;
        }

        //如果开始标签的第一个字符是{或者[
        $isNextTag  = substr($configStr,$indexIndex+strlen($str),1);
        //查找第一个反向标签
        if ($isNextTag && $isNextTag == '{' ){
            if (!$nextTagIndex = strpos($configStr,'}',$indexIndex+strlen($str))){
                $errArr['finxConfig'] = '查找反向标签}失败'.$str;
                return false;
            }
            $tagnextStr = substr($configStr,$indexIndex,$nextTagIndex-$indexIndex+1);

            //截取取到第一个同向标签的同标签的数量
            $TagCount = substr_count($tagnextStr,'{');

            $TagArr = explode('}',substr($configStr,$indexIndex+strlen($str)));
            if (count($TagArr) < $TagCount){
                $errArr['finxConfig'] = '标签{闭合失败'.$str;
                return false;
            }
            $resStr = '';
            for ($i = 0 ; $i < $TagCount ; $i++){
                $resStr .= $TagArr[$i]."}";
            }
            $resStr = str_replace(['\'','\"'],['',''],$resStr);
            $this->debugArr[] = $resStr ;
            return $resStr;
        }
        if ($isNextTag && $isNextTag == '['){
            if (!$nextTagIndex = strpos($configStr,']',$indexIndex+strlen($str))){
                $errArr['finxConfig'] = '查找反向标签]失败'.$str;
                return false;
            }
            $tagnextStr = substr($configStr,$indexIndex,$nextTagIndex-$indexIndex+1);

            //截取取到第一个同向标签的同标签的数量
            $TagCount = substr_count($tagnextStr,'[');

            $TagArr = explode(']',substr($configStr,$indexIndex+strlen($str)));
            if (count($TagArr) < $TagCount){
                $errArr['finxConfig'] = '标签[闭合失败'.$str;
                return false;
            }
            $resStr = '';
            for ($i = 0 ; $i < $TagCount ; $i++){
                $resStr .= $TagArr[$i]."]";
            }
            $resStr = str_replace(['\'','\"'],['',''],$resStr);
            $this->debugArr[] = $resStr ;
            return $resStr;

        }
        //如果为空 判断是否是最后一个标签
        if (!$endIndex =  strpos($configStr,",",$indexIndex)){
            $ll = substr($configStr,$indexIndex+strlen($str));
//            var_dump($ll);exit();
            if (!$endIndex = strpos($ll,"}")){
                $errArr['finxConfig'] = '查找不是结尾标签'.$str;
                return false;
            }
//            $endIndex = $indexIndex+strlen($str) + $endIndex;
        }
        $resStr = substr($configStr,$indexIndex+strlen($str),$endIndex-$indexIndex-strlen($str));

        $resStr = str_replace(['\'','\"'],['',''],$resStr);
        $this->debugArr[] = $resStr ;
        return $resStr;


    }

    /**
     * 请求URL
     * @param $url
     * @param $header
     * @return mixed
     */
    public function getHtml($url,$header){
        if (!isset(self::$curlHtmlDom[$url])){
            curl_setopt(self::$curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt(self::$curl, CURLOPT_URL, $url);
            curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(self::$curl, CURLOPT_HEADER, 0);
            curl_setopt(self::$curl, CURLOPT_FOLLOWLOCATION, 1);
            $output = curl_exec(self::$curl);

            $fileType = mb_detect_encoding($output , array('UTF-8','GBK','LATIN1','BIG5' , 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1')) ;
            $output = mb_convert_encoding($output ,'utf-8' , $fileType);


            //缓存数据
            self::$curlHtmlDom[$url] = $output;
        }
        return self::$curlHtmlDom[$url];
    }


}