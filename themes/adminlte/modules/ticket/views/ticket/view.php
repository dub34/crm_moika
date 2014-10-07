<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('ticket', 'Update'), ['update', 'id' => $model->id, 'contract_id' => $model->contract_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('ticket', 'Delete'), ['delete', 'id' => $model->id, 'contract_id' => $model->contract_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('ticket', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'contract_id',
            'created_at',
            'closed_at',
            'priznak',
            'pometka',
        ],
    ]) ?>

</div>
