<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 21.04.15
 * Time: 12:55
 */
use \kartik\field\FieldRange;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['method' => 'GET', 'options' => ['style' => 'width:400px;']]); ?>
<?=
FieldRange::widget([
	'label' => Yii::t('contract', 'Select date range'),
	'form' => $form,
	'model' => $saldoModel,
	'id' => 'client_payment_d_r',
	'attribute1' => 'date_start',
	'attribute2' => 'date_stop',
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
<?= Html::submitButton(Yii::t('contract', 'Get'), ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>