<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/12
 * Time: 上午1:20
 */

namespace api\jd\pice;


use api\models\GoodPrice;
use api\models\GoodPriceLog;
use yii\base\Object;

class JdPiceSreach extends Object
{
    public static $curl;

    public function init(){
        if (empty(self::$curl)){
            self::$curl = curl_init();
        }
    }

    public $sellType = "jd";

    /**
     * 带缓存
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
     */
    public function getTitle($itemId,&$errArr){
        // https://item.jd.com/16182548288.html
        $url = "https://item.jd.com/{$itemId}.html";
        $header = [
            'Accept: */*',
//            'Connection: keep-alive',
//            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: zh-CN,zh;q=0.8',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
        ];

        curl_setopt(self::$curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(self::$curl, CURLOPT_HEADER, 0);
        $output = curl_exec(self::$curl);

        $output = substr($output,0,1000);
//        var_dump($output);exit();
//        var_dump(mb_detect_encoding($output, "auto"));exit();
        $fileType = mb_detect_encoding($output , array('UTF-8','GBK','LATIN1','BIG5' , 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1')) ;
        $output = mb_convert_encoding($output ,'utf-8' , $fileType);



        if (!$startIndex = strpos($output,'<title>')){
            $errArr['getTitle'][] = '获取商品标题失败 url:'.$url;
            return false;
        }
//        var_dump($output);exit();

        if (!$nextIndex = strpos($output,'</title>')){
            $errArr['getTitle'][] = '获取商品尾巴标题标签失败 url:'.$url;
            return false;
        }

        $length = $nextIndex - $startIndex + 8;
        if ($title = substr($output,$startIndex+7,$length)){
            if ($myIndex = strpos($title,'【图片 价格 品牌 报价】')){
                return substr($title,0,$myIndex);
            }
            return $title;
        }
        $errArr['getTitle'][] = '截取标题失败 url:'.$url;
        return false;




    }


}