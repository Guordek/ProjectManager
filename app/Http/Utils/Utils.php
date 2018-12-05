<?php
/**
 * Created by PhpStorm.
 * User: Dodskamp
 * Date: 05.12.2018
 * Time: 09:15
 */

namespace App\Http\Utils;


class Utils
{

    public function __construct() {

    }

    public function check_diff_multi($array1, $array2){
        $result = array();
        foreach($array1 as $key => $val) {
            if(isset($array2[$key])){
                if(is_array($val) && $array2[$key]){
                    $result[$key] = check_diff_multi($val, $array2[$key]);
                }
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}