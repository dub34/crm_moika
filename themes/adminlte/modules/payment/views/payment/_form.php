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
//$script = <<<SKRIPT
//$(document).pjax('#payment_form_pjax_container');
//SKRIPT;
//$this->registerJs($script);
?>

<?php Pjax::begin(['id' => 'payment_form_pjax_container', 'enablePushState'=>false,'enableReplaceState'=>false,'timeout'=>5000]); ?>


<?php
if (is_array($messages = Yii::$app->getSession()->getAllFlashes()) && count($messages)>0) {

    Alert::begin([
        'options' => [
            'class' => 'alert-success'
        ],
        'id'=>'payment_form_alert'
    ]);
    foreach ($messages as $message) {
        echo Html::tag('p', $message);
    }
    Alert::end();
}
?>
<div class="payment-form">

    <?php
    $form = ActiveForm::begin([
                'action' => Url::to('/payment/payment/create'),
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => ['data-pjax' => '#payment_form_pjax_container']
    ]);
    ?>
    <?php
    $contract = Contract::find();
    if (isset($client_id))
        $contract->where(['client_id' => $client_id]);
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

    <div class="form-group">
<?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success', 'pjax:error' => 'function(){alert("11");}', 'data-pjax' => '#payment_form_pjax_container']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>