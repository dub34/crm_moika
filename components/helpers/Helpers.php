<?php
namespace app\components\helpers;

class Helpers {

	/**
	 * @param $number
	 * @param int $accuracy
	 * @return float
	 */
    public static function roundUp($number, $accuracy = 1)
    {

        $accuracy = \Yii::$app->settings->get('main.roundAccuracy') ?: $accuracy;
        if ($accuracy != 1)
            $number = round($number / $accuracy) * $accuracy;
        return $number;
    }

}
