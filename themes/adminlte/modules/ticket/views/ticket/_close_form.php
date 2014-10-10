<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use \app\modules\office\models\Office;
use app\modules\service\models\ServiceHistory;
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
            'action' => Url::to(['/ticket/ticket/update', 'id' => $model->id, 'contract_id' => $model->contract_id])
        ]);

$serviceloadurl=Url::to('/service/service/getactualversionsbydate');
?>
<?=

DatePicker::widget([
    'form' => $form,
    'model' => $model,
    'attribute' => 'closed_at',
    'options' => ['id' => 'closed_at-' . $model->id],
    'pluginEvents'=>['changeDate'=>"function(e){var selected = $('#ticket-services_list-{$model->id}').select2('val'); $('#ticket-services_list-{$model->id}').load('{$serviceloadurl}',{date:e.format(),ticket_id:{$model->id} },function(data){ $('#ticket-services_list-{$model->id}').html(data); $('#ticket-services_list-{$model->id}').val(selected).trigger('change');}); }"],
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy',
        'autoclose' => true,
    ]
]);
?>
<?= $form->field($model, 'office_id')->dropDownList(ArrayHelper::map(Office::find()->all(), 'id', 'name'), ['prompt' => Yii::t('ticket', 'Select office')]); ?>

<?php // $form->field($model, 'services_list')->dropDownList(ArrayHelper::map(ServiceHistory::getActualVersionsByDate($model->closed_at) , 'id', 'name'), ['multiple'=>true,'id'=>'services_list-'.$model->id]);  ?>


<?=

$form->field($model, 'services_list')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(ServiceHistory::getActualVersionsByDate($model->closed_at), 'id', 'name'),
    'size' => Select2::MEDIUM,
    'options' => ['multiple' => true,'id'=>'ticket-services_list-'.$model->id],
    'pluginOptions' => [
        'allowClear' => true,
    ]
]);
?>

<?= $form->field($model, 'contract_id', ['template' => '{input}'])->hiddenInput(); ?>

<?= Html::submitButton(Yii::t('ticket', 'Save Ticket'), ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>