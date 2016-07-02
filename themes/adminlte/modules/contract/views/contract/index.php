<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\web\JqueryAsset;
use yii\helpers\ArrayHelper;
use app\modules\client\models\Client;
use app\components\helpers\Helpers;

$script = <<<SKRIPT
    $('#pjax-action-container').on('pjax:success', function(xhr,data, status,  options){         
         handlePaymentFormActions();
     });
    $('#pjax-action-container').on('pjax:start', function(data){
        $(this).find('.box').append('<div class="overlay"></div><div class="loading-img"></div>');
     });
   
SKRIPT;

\yii\widgets\ActiveFormAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->registerJsFile('/themes/adminlte/js/plugins/datepicker/bootstrap-datepicker.js',
	['depends' => [JqueryAsset::className()], 'position' => $this::POS_END]);
$this->registerJs($script);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\SearchContract $searchModel
 */
?>
<div class="row">
	<div class="col-md-7 col-lg-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Договоры</h3>

				<div class="box-tools">
					<p class="pull-left">
						<?= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-briefcase']),
							['/contract/contract/create', 'Contract[client_id]' => $searchModel['client_id']],
							['class' => 'btn btn-success btn-sm font-white']); ?>
					</p>
				</div>
			</div>
			<div class="box-body no-padding">
				<?=
				GridView::widget([
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'summary' => false,
					'id' => 'contract_grid',
					'striped' => false,
					'bordered' => false,
					'export'=>false,
//					'resizableColumns'=>false,
	//					'panel'=>[
	//						'headingTemplate' => '
	//    <div class="pull-right">
//        {pager}
//    </div>
//    <div class="clearfix"></div>
//'
//					],

                    'layout' => '{pager}<div class="clearfix"></div>{items}',
					'pager' => [
						'options' => [
							'class' => 'pagination pagination-sm pull-right no-margin'
						],
						'maxButtonCount' => 5
					],
					'tableOptions' => ['data-balanceloadurl' => yii\helpers\Url::to('/contract/contract/getbalance')],
					'columns' => [
						[
							'attribute' => 'number',
                            'options' => ['class' => 'col-md-1'],
							'value' => function ($model) {
								return Html::a($model->number, ['/contract/contract/update', 'id' => $model->id]);
							},
							'format' => 'raw',
							'filterInputOptions' => ['class'=>'form-control input-sm'],
						],
						[
							'attribute' => 'client_id',
							'vAlign' => 'middle',
							'value' => 'client.name',
							'filterType' => GridView::FILTER_SELECT2,
							'filter' => ArrayHelper::map(Client::find()->isDeleted(false)->orderBy('name')->asArray()->all(),
								'id', 'name'),
							'filterWidgetOptions' => [
								'size'=>'sm',
								'pluginOptions' => ['allowClear' => true],
							],
							'filterInputOptions' => ['placeholder' => Yii::t('client', 'Select client')],
							'format' => 'raw',
							'options' => ['class' => 'col-md-2'],
						],
						[
							'attribute' => 'created_at',
							'filter' => false
						],
						[
							'attribute' => 'balance',
							'value' => function ($model, $key, $index) {
								return Html::tag('span',
									Yii::$app->formatter->asDecimal(Helpers::roundUp($model->balance), 2),
									['class' => $model->balance < Yii::$app->settings->get('contract.minBalance') ? 'label label-danger' : 'label label-success']);
							},
							'format' => 'raw',
							'contentOptions' => function ($model, $key, $index, $column) {
								return ['id' => 'balance-' . $key];
							}
						],
						[
							'value' => function ($model, $key, $index) {
								return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-usd']),
									['/payment/payment/loadpaymentgrid', 'contract_id' => $model->id], [
										'class' => 'load-payments',
										'title' => Yii::t('payment', 'Show Payments'),
										'data-id' => $model->id,
										'data-pjax' => '#pjax-action-container'
									]);
							},
							'format' => 'raw'
						],
						[
							'value' => function ($model, $key, $index) {
								return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list']),
									['/ticket/ticket/loadticketsgrid', 'id' => $model->id], [
										'class' => 'load-tickets',
										'title' => Yii::t('ticket', 'Show Tickets'),
										'data-id' => $model->id,
										'data-pjax' => '#pjax-action-container'
									]);
							},
							'format' => 'raw'
						],
						[
							'value' => function ($model, $key, $index) {
								return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list-alt']), '#',
								[
									'class' => 'print-act',
									'title' => Yii::t('contract', 'Print act'),
									'data-id' => $model->id,
									'data-pjax' => '0',
									'data-toggle' => "modal",
									'data-target' => "#printAct-" . $key
								])
								. $this->render('//modules/ticket/views/ticket/_act_modal', ['id' => $key]);
							},
							'format' => 'raw'
						],
					]
				]);
				?>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-lg-6">
		<?php Pjax::begin([
			'id' => 'pjax-action-container',
			'options' => ['class' => 'pjax-wrapper'],
			/* 'linkSelector' => '#pjax-action-container a', */
			'enablePushState' => false,
			'enableReplaceState' => false,
			'timeout' => 90000
		]); ?>
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><?= Yii::t('yii', 'Выберите действие'); ?></h3>
			</div>
		</div>
		<?php Pjax::end(); ?>
	</div>
</div>
