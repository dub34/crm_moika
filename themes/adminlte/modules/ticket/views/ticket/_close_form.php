<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use \app\modules\office\models\Office;
use \app\modules\service\models\Service;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

?>
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
            'id' => 'closeticketform-' . $model->id,
            'action' => Url::to(['/ticket/ticket/update','id'=>$model->id,'contract_id'=>$model->contract_id])
        ]);
?>
<?=
DatePicker::widget([
    'form' => $form,
    'model' => $model,
    'attribute' => 'closed_at',
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy',
        'autoclose' => true,
    ]
]);
?>
<?= $form->field($model, 'office_id')->dropDownList(ArrayHelper::map(Office::find()->all(), 'id', 'name'), ['prompt' => Yii::t('ticket', 'Select office')]); ?>

<?= $form->field($model, 'services_list')->dropDownList(ArrayHelper::map(Service::find()->all(), 'id', 'name'), ['prompt' => Yii::t('ticket', 'Select service'),'multiple'=>true]); ?>


<?= $form->field($model, 'contract_id', ['template' => '{input}'])->hiddenInput(); ?>

<?= Html::submitButton(Yii::t('ticket', 'Save Ticket'), ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>