<?php

namespace app\modules\ticket\controllers;

use app\components\controllers\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('ticket/ticket');
    }
}
