<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('payment', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('payment', 'Update'), ['update', 'id' => $model->id, 'contract_id' => $model->contract_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('payment', 'Delete'), ['delete', 'id' => $model->id, 'contract_id' => $model->contract_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('payment', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'contract_id',
            'payment_sum',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
