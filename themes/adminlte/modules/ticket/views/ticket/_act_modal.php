<?php
use app\modules\contract\models\Contract;
use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\field\FieldRange;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Print act modal window with form
 * @var $model Contract
 * @var $id integer
 *
 */


$model = new app\modules\ticket\models\SearchTicket();
$model->contract_id = $id;
$model->closed_at = date("d.m.Y", strtotime("first day of last month"));
$model->closed_to_date = date("d.m.Y", strtotime("last day of last month"));
$model->actDate =  date("d.m.Y", time());
?>
<?php Modal::begin([
    'id' => 'printAct-' . $id,
    'header' => '<h3>' . Yii::t('contract', 'Print act') . '</h3>',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?php $form = ActiveForm::begin(['action' => Url::to('/ticket/ticket/printact'), 'method' => 'GET', 'id' => 'printActForm-' . $model->contract_id, 'options' => ['target' => '_blank', 'class' => 'printActForm', 'data-pjax' => 0]]); ?>

<?= $form->field($model, 'contract_id', ['template' => '{input}'])->hiddenInput(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= FieldRange::widget([
                'label' => Yii::t('ticket', 'Act date range'),
                'form' => $form,
                'model' => $model,
                'id' => 'act-range-' . $model->contract_id,
                'attribute1' => 'closed_at',
                'attribute2' => 'closed_to_date',
                'useAddons' => false,
                'separator' => '&larr;&rarr;',
                'type' => FieldRange::INPUT_DATE,
                'widgetOptions1' => [
                    'pluginOptions' => ['autoclose' => true, 'format' => 'dd.mm.yyyy'],
                ],
                'widgetOptions2' => [
                    'pluginOptions' => ['autoclose' => true, 'format' => 'dd.mm.yyyy'],
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-4">
            <label class="control-label">От</label>
            <?= DatePicker::widget([
                'options' => ['id' => 'act-date-' . $model->contract_id],
                'pluginOptions' => ['autoclose' => true, 'format' => 'dd.mm.yyyy'],
//                'value' =>,
                'model' => $model,
                'attribute' => 'actDate'
            ]); ?>
        </div>
    </div>

<?= Html::submitButton(Yii::t('ticket', 'Form act'), ['class' => 'btn btn-success']); ?>

<?php ActiveForm::end(); ?>
<?= Html::button('Распечатать', ["id" => 'printBtn', 'class' => 'btn btn-primary', 'style' => 'display: none;']); ?>
    <br/>
    <iframe class="act" name="actPrintFrame" width="100%" height="0"></iframe>
<?php Modal::end(); ?>