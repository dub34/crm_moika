<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

    <?php
    $form = ActiveForm::begin(
        [
            'action' => Url::to('/ticket/ticket/create'),
            'options' => ['data-pjax' => '0','data-printurl'=>Url::to(['/ticket/ticket/printtickets','contract_id'=>$model->contract_id,'ticket_count'=>$model->ticket_count])], 
            'id' => 'ticketPrintCountForm'
        ]);
    ?>
    <?= $form->field($model, 'ticket_count')->textInput(['value' => '1']); ?>
    <?= $form->field($model, 'contract_id',['template' => '{input}'])->hiddenInput(); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('ticket', 'Save and print'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
