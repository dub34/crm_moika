<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\field\FieldRange;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/**
 * Print act modal window with form
 * @var $model instance of Contract model class
 */


$model = new app\modules\ticket\models\SearchTicket();
$model->contract_id = $id;
?>
<?php Modal::begin([
    'id'=>'printAct-'.$id,
    'header'=>'<h3>'.Yii::t('contract','Print act').'</h3s>',
    'size'=>  Modal::SIZE_LARGE,
//    'toggleButton' => ['label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-list-alt']), 'title' => Yii::t('contract', 'Print act'), 'class' => 'btn btn-primary btn-sm'],
]);?>

<?php $form = ActiveForm::begin(['action'=>Url::to('/ticket/ticket/printact'),'id'=>'printActForm-'.$model->contract_id,'options'=>['class'=>'printActForm','data-pjax'=>0]]); ?>

<?= $form->field($model,'contract_id',['template'=>'{input}'])->hiddenInput();?>
<?= FieldRange::widget([
    'label' => Yii::t('ticket','Act date range'),
    'form'=>$form,
    'model'=>$model,
    'id'=>'act-range-'.$model->contract_id,
    'attribute1' => 'closed_at',
    'attribute2' => 'closed_to_date',
    'useAddons'=>false,
    'separator' => '&larr;&rarr;',
    'type' => FieldRange::INPUT_DATE,
    'widgetOptions1' => [
            'pluginOptions' => ['autoclose' => true,'format' => 'dd.mm.yyyy'],
    ],
    'widgetOptions2' => [
            'pluginOptions' => ['autoclose' => true,'format' => 'dd.mm.yyyy'],
    ],
]);
?>

<?= Html::submitButton(Yii::t('ticket','Form act'),['class'=>'btn btn-success']); ?>

<?php ActiveForm::end(); ?>

<br />
<iframe class="act" width="100%" height="0"></iframe>
<?php Modal::end();?>