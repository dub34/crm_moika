<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 */

$this->title = Yii::t('payment', 'Create {modelClass}', [
  'modelClass' => 'Payment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('payment', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
