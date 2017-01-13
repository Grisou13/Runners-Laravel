<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 13.01.2017
 * Time: 09:07
 */
namespace App\Http\Helpers;

class Helper{
    public static function mkRange($start,$end){
        $count = Helper::strToInt($end) - Helper::strToInt($start);
        $r = array();
        do {$r[] = $start++;} while ($count--);
        return $r;
    }

    public static function strToInt($str){
        $str = strrev($str);
        $dec = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $dec += (base_convert($str[$i],36,10)-9) * pow(26,$i);
        }
        return $dec;
    }
}
