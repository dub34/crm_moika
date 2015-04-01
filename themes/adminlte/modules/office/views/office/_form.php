<?php

use app\modules\employee\models\Employee;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="office-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'register_address')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'chief_name')->dropDownList(ArrayHelper::map(Employee::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'glbuh_name')->dropDownList(ArrayHelper::map(Employee::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'check_buh_name')->dropDownList(ArrayHelper::map(Employee::find()->all(), 'id',
        'name')); ?>

    <?= $form->field($model, 'bank_name')->textInput() ?>

    <?= $form->field($model, 'bank_code')->textInput() ?>

    <?= $form->field($model, 'payment_account')->textInput() ?>

    <?= $form->field($model, 'unp')->textInput() ?>

    <?= $form->field($model, 'okpo')->textInput() ?>

    <?= $form->field($model, 'telephone')->textInput() ?>

    <?= $form->field($model, 'fax')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 45]) ?>

    <div class="row">
        <?php if ($model->logo) : ?>
            <div class="col-md-1">
                <?= Html::img('/' . $model->logo, ['width' => 100]); ?>
            </div>
        <?php endif; ?>
        <div class="col-md-2">
            <?= $form->field($model, 'uploadedFile')->fileInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(/*$model->isNewRecord ? 'Создать' :*/
            'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
