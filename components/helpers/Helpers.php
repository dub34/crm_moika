<?php
namespace app\components\helpers;

class Helpers {

    //Round numbers
    public static function roundUp($number, $accuracy = 50) {
        if ($accuracy != 1)
            $number = ceil($number / $accuracy) * $accuracy;
        return $number;
    }

}
