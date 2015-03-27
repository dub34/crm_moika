<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 27.03.15
 * Time: 20:31
 */
namespace app\components\controllers;

?>
<?php

class SettingsController extends \pheme\settings\controllers\DefaultController
{
	public function behaviors()
	{
		$behaviors = [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
//			'LiveLayoutBehavior'=>array('class'=>  LiveLayoutBehavior::className()),
		];
		return array_merge(parent::behaviors(), $behaviors);
	}
}

?>