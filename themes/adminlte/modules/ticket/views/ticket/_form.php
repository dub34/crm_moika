<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contract_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'closed_at')->textInput() ?>

    <?= $form->field($model, 'priznak')->textInput() ?>

    <?= $form->field($model, 'pometka')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('ticket', 'Create') : Yii::t('ticket', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
