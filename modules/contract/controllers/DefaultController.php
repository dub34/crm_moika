<?php

namespace app\modules\contract\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('contract/contract');
    }
}
