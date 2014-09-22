<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="office-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>
    <div class="form-group">
        <?= Html::submitButton(/*$model->isNewRecord ? 'Создать' :*/ 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
