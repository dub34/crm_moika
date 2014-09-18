<?php

namespace app\modules\main\controllers;

use app\components\controllers\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    public function behaviors()
    {
        $behaviors =  [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],
            ],
        ];
        return array_merge(parent::behaviors(),$behaviors);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionIndex()
    {
//        $this->params['breadcrumbs'][] = 'About Us';
        return $this->render('index');
    }
 
    public function actionAbout()
    {
        return $this->render('about');
    }
}