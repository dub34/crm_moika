<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\contract\models\Contract;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php // Pjax::begin(['id' => 'payment_form_pjax_container', 'enablePushState' => false, 'enableReplaceState' => false, 'timeout' => 5000]); ?>

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
                'action' => Url::to('/payment/payment/create'),
                'options'=>['data-pjax'=>'0'],
                'enableClientScript'=>true,
                'id'=>'payment_form',
        
//                'enableClientValidation'=>false,
//                'enableAjaxValidation'=>false,
//        
                
    ]);
    ?>
    <?php
    $contract = Contract::find();
    if (isset($model->contract_id))
        $contract->where(['id' => $model->contract_id]);
    ?>

    <?= $form->field($model, 'contract_id', ['inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="ion ion-briefcase"></i></span>{input}</div>',])->dropDownList(ArrayHelper::map($contract->all(), 'id', 'number'), ['prompt' => Yii::t('contract', 'Select contract')]); ?>

    <?=
//    $form->field($model,'created_at')->textInput();
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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success','id'=>'submitPaymentForm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php // Pjax::end(); ?>