<?php

namespace app\modules\service\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('service/service');
    }
}
