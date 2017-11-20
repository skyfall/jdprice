<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/11/19
 * Time: 下午7:58
 */

namespace api\jd\pice;


use yii\base\Object;

class JdPriceHistory extends Object
{
    public $zero = ['0','00','000','0000','00000','000000','0000000','00000000'];

    public $chars = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

    public function encrype($a,$b,$e){
        $a1=$this->shuzi($a);
        $a2=$this->zimu($a);
        $a=$a2.$a1;
        $g = [];
        $i=strlen($a);
        for($f=0; $f<$i; $f++){
            $g[count($g)]=$this->to(ord(substr($a,$f,1)),$b);
        }
        $str = $this->rnd($e ? $this->strReverse(implode('',$g)) : implode('',$g),4);
        return $str;
    }

    public function rnd($a,$b){
        return $this->rd($b).md5($a).$this->rd(rand(0,10));

    }
    public function rd($a){
        $res="";
        for ($i = 0; $i<$a ; $i++){
            $res.= $this->chars[rand(0,35)];
        }
	    return $res;
    }

    function strReverse($a)
    {
        $b = 0;
        $c = [];
        for ($i = strlen($a); $b < $i; $b++) {
            $c[count($c)] = substr($a,$b,1);
        }
        $c = array_reverse($c);
        return implode('',$c);
    }




    public function to($a,$c){
        $e = ($this->round($a+88,$c));
        $e = (dechex($e));
        $f = $c - strlen($e);
        return $f>0 ? $this->zero[$f - 1].$e : $e;
    }

    public function round($a,$b){
        $c = 1 << 4*$b;
        return 0> $a ? $a%$c + $c : $a%$c;
    }

    public function shuzi($a){
        $arr = [];
        preg_match('/\d+/',$a,$arr) ;
        return isset($arr[0]) && is_numeric($arr[0]) ? $arr[0] : 0;
    }

    function zimu($str){
        $str = strtolower($str);
        str_replace('https','http',$str);
        $result =[];
        preg_match_all('/[a-z]/' , $str, $result);
        $resStr = '';
        
        if (!isset($result[0])){
            return '';
        }
        foreach ($result[0] as $strl){
            $resStr .= $strl;
        }
        return $resStr;
//        return a.toLowerCase().replace(/http/g,"http").replace(/[^a-zA-Z]+/ig,"")
    }


}