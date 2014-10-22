<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\contract\models\Contract;
use kartik\widgets\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="payment-form">
<?php
if (is_array($messages = Yii::$app->getSession()->getAllFlashes()) && count($messages) > 0) {

    Alert::begin([
        'options' => [
            'class' => 'alert-success'
        ],
        'id' => 'payment_form_alert'
    ]);
    foreach ($messages as $message) {
        echo Html::tag('p', $message);
    }
    Alert::end();
}
?>

    <?php
    $form = ActiveForm::begin([
                'action' => Url::to(['/payment/payment/create','id'=>$model->id,'contract_id'=>$model->contract_id]),
                'options'=>['data-pjax'=>'0'],
                'enableClientScript'=>true,
                'id'=>'payment_form',
    ]);
    ?>
    <?php
    $contract = Contract::find();
    if (isset($model->contract_id))
        $contract->where(['id' => $model->contract_id]);
    ?>
    <?= $form->field($model, 'contract_id', ['inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="ion ion-briefcase"></i></span>{input}</div>',])->dropDownList(ArrayHelper::map($contract->all(), 'id', 'number'), ['prompt' => Yii::t('contract', 'Select contract')]); ?>
    <?=
    DatePicker::widget([
        'model' => $model,
        'attribute' => 'created_at',
        'form' => $form,
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
            'autoclose' => true,
        ]
    ]);
    ?>
    <?= $form->field($model, 'payment_sum')->textInput(['maxlength' => 25]) ?>
    <?= $form->field($model, 'status')->dropDownList(['0'=>Yii::t('payment','nonactive'),'1'=>Yii::t('payment','active')]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('payment', 'Save'), ['class' => 'btn btn-success','id'=>'submitPaymentForm']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>