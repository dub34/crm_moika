<?php

namespace app\modules\client\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('client/client');
    }
}
