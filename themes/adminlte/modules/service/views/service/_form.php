<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\service\models\Service $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="service-form col-md-6">
    <div class="box box-primary">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name')->textInput(); ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 2]); ?>
            <?= $form->field($model, 'price')->textInput(); ?>
        </div>

        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>
