<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\client\models\Client;
use kartik\widgets\DatePicker;

/**
 * @var yii\web\View $this
 * @var app\modules\contract\models\Contract $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="contract-form col-md-6">
    <div class="box box-primary">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'number',
                ['inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>{input}</div>',]); ?>

            <?= $form->field($model, 'client_id',
                ['inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>',])->dropDownList(ArrayHelper::map(Client::find()->isDeleted(false)->all(),
                'id', 'name'), ['prompt' => Yii::t('contract', 'Select client')]); ?>
            <?php //  $form->field($model, 'employee_id')->textInput() ?>
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'created_at',
                'form' => $form,
                'value'=>'2',
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                ]
            ]);
            ?>
        </div><!-- /.box-body -->
        <div class="box-footer">

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('contract', 'Create') : Yii::t('contract', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
