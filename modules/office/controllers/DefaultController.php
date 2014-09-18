<?php

namespace app\modules\office\controllers;

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
    public function actionIndex()
    {
        return $this->render('index');
    }
}
