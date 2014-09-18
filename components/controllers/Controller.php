<?php
namespace app\components\controllers;

use app\components\behaviors\LiveLayoutBehavior;
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
        return array_merge(parent::behaviors(), [
            'LiveLayoutBehavior'=>array('class'=>  LiveLayoutBehavior::className()),
        ]);
    }
    
    public function beforeAction($action) {
        $this->initLayout();
        return parent::beforeAction($action);
    }
}