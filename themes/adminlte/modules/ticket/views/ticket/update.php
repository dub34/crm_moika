<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = Yii::t('ticket', 'Update {modelClass}: ', [
    'modelClass' => 'Ticket',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'contract_id' => $model->contract_id]];
$this->params['breadcrumbs'][] = Yii::t('ticket', 'Update');
?>
<div class="ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
