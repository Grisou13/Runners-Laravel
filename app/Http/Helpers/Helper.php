<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 13.01.2017
 * Time: 09:07
 */
namespace App\Http\Helpers;

class Helper{

    /**
     * This function is used to get the alphabet (characters)
     * @param $start ex: 'A'
     * @param $end ex: 'ZZ'
     * @return array ex: ['A','B','C',...'ZZ']
     */
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

    /**
     * Get a random color
     * The available colors are in the config (config/group.php)
     * @return string color
     */
    public static function getRandomGroupColor(){
        $c = \Config::get("group.colors");
        return $c[mt_rand(0, count($c) -1)];
    }

    /**
     * Assign a color to the given based on its ID
     * @param string $groupId
     * @return string color
     */
    public static function assignGroupColor($groupId){
        $c = \Config::get("group.colors");

        $nbColor = count($c);
        // each group get its color based on its ID's number
        if($groupId <= $nbColor){
            return $c[$groupId - 1];
        }else{ // but what append if we have 20 groups for only 10 colors ?
            $timesBigger = intval($groupId / $nbColor);
            return $c[
                $groupId - ($nbColor * $timesBigger)
            ];
        }
        return false;
    }
}
