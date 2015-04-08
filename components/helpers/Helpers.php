<?php
namespace app\components\helpers;

class Helpers {

    //Round numbers
    public static function roundUp($number, $accuracy = 1)
    {

        $accuracy = \Yii::$app->settings->get('main.roundAccuracy') ?: $accuracy;
        if ($accuracy != 1)
            $number = ceil($number / $accuracy) * $accuracy;
        return $number;
    }

}
