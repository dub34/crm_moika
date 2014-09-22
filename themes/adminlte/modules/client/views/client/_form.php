<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var yii\web\View $this
 * @var app\modules\client\models\Client $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="client-form">

    <?php
    $form = ActiveForm::begin(
                    [
//                        'enableAjaxValidation'=>true,
//                        'enableClientValidation'=>false,
                    ]
    );
    ?>

    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => 45]) ?>

    <div class="row">
        <?= $form->field($model, 'register_address', ['options' => ['class' => 'col-xs-6 form-group']])->textarea(['rows' => 2]) ?>
        <?= $form->field($model, 'post_address', ['options' => ['class' => 'col-xs-6 form-group']])->textarea(['rows' => 2]) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'chief_name', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
        <?= $form->field($model, 'chief_post', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
        <?= $form->field($model, 'responsible_person', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'bank_name', ['options' => ['class' => 'col-xs-4 form-group']])->textarea(['rows' => 1]) ?>
        <?= $form->field($model, 'bank_code', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
        <?= $form->field($model, 'payment_account', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'unp', ['options' => ['class' => 'col-xs-6 form-group']])->textInput(); ?>
        <?= $form->field($model, 'okpo', ['options' => ['class' => 'col-xs-6 form-group']])->textInput() ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'fax', ['options' => ['class' => 'col-xs-4 form-group']])->textInput() ?>
        <div class="col-xs-4 form-group">
            <?= Html::activeLabel($model, 'telephone'); ?>
            <?=
            MaskedInput::widget([
                'model' => $model,
                'attribute' => 'telephone',
                'mask' => '+375-99-999-9999',
            ]);
            ?>
            <?= Html::error($model, 'telephone'); ?>
        </div>
        <?= $form->field($model, 'email', ['options' => ['class' => 'col-xs-4 form-group']])->textInput(['maxlength' => 45]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
