<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 */

$this->title = Yii::t('payment', 'Update {modelClass}: ', [
  'modelClass' => 'Payment',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('payment', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'contract_id' => $model->contract_id]];
$this->params['breadcrumbs'][] = Yii::t('payment', 'Update');
?>
<div class="payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
