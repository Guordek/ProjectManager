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

    public function __construct()
    {

    }

    public static function check_diff_multi($array1, $array2)
    {
        $result = array();
        foreach ($array1 as $key => $val) {
            if (isset($array2[$key])) {
                if (is_array($val) && $array2[$key]) {
                    $result[$key] = check_diff_multi($val, $array2[$key]);
                }
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }

}