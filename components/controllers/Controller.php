<?php
namespace app\components\controllers;

use app\components\behaviors\LiveLayoutBehavior;
use yii\filters\AccessControl;
/**
 * Extend base Contoller with LiveLayoutBehavior
 * 
 * @author v.kriuchkov
 * @since 2.0
 */
class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        $behaviors=[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'LiveLayoutBehavior'=>array('class'=>  LiveLayoutBehavior::className()),
        ];
        return array_merge(parent::behaviors(), $behaviors);
    }
    
    public function beforeAction($action) {
        $this->initLayout();
        return parent::beforeAction($action);
    }
}