<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="employee-form col-md-6">
    <div class="box box-primary">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(); ?>
        </div>

        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
