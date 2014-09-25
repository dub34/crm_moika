<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\PaymentSearch $searchModel
 */

$this->title = Yii::t('payment', 'Payments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">
    <?= $this->render('_grid',['paymentDP'=>$paymentDP]); ?>
</div>
