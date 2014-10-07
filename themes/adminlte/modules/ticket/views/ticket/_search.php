<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\SearchTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'contract_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'closed_at') ?>

    <?= $form->field($model, 'priznak') ?>

    <?php // echo $form->field($model, 'pometka') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ticket', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('ticket', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
