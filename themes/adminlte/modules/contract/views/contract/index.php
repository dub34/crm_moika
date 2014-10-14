<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\web\JqueryAsset;
use yii\helpers\ArrayHelper;
use app\modules\client\models\Client;

$script = <<<SKRIPT
    $('#pjax-action-container').on('pjax:success', function(data){
         handlePaymentFormActions();
     });
   
SKRIPT;

\yii\widgets\ActiveFormAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->registerJsFile('/themes/adminlte/js/plugins/datepicker/bootstrap-datepicker.js', ['depends' => [JqueryAsset::className()], 'position' => $this::POS_END]);
$this->registerJs($script);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\SearchContract $searchModel
 */
$this->title = Yii::t('contract', 'Contracts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => false,
                    'id' => 'contract_grid',
                    'striped' => true,
                    'bordered' => false,
                    'layout' => '<p>{pager}</p>{items}',
                    'pager' => [
                        'options' => [
                            'class' => 'pagination pagination-sm pull-right no-margin'
                        ],
                        'maxButtonCount' => 5
                    ],
//                     'tableOptions' => ['class' => 'table table-stripped'],
                    'columns' => [
    //                        'id',
                        [
                            'attribute' => 'number',
                            'options' => ['class' => 'col-md-1'],
                        ],
//                        [
//                            'attribute' => 'client',
//                            'value' => 'client.name',
//                        ],
                        [
                        'attribute' => 'client_id',
                        'vAlign' => 'middle',
                        'value' => 'client.name',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(Client::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                        'filterInputOptions' => ['placeholder' => Yii::t('client','Select client')],
                        'format' => 'raw'
                        ],
                        'created_at',
    //                        ['class' => 'yii\grid\ActionColumn', 'options' => ['class' => 'col-md-1']],
                        'balance',
                        [
                            'value' => function($model, $key, $index) {
                                return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-usd']), ['/payment/payment/loadpaymentgrid', 'id' => $model->id], ['class' => 'load-payments', 'title' => Yii::t('payment', 'Show Payments'), 'data-id' => $model->id, 'data-pjax' => '#pjax-action-container']);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'value' => function($model, $key, $index) {
                                return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list']), ['/ticket/ticket/loadticketsgrid', 'id' => $model->id], ['class' => 'load-tickets', 'title' => Yii::t('ticket', 'Show Tickets'), 'data-id' => $model->id, 'data-pjax' => '#pjax-action-container']);
                            },
                                    'format' => 'raw'
                        ],
                        [
                            'value' => function($model, $key, $index) {
                                return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list-alt']), '#', ['class' => 'print-act', 'title' => Yii::t('contract', 'Print act'), 'data-id' => $model->id, 'data-pjax' => '0'])
                                        .$this->render('//modules/ticket/views/ticket/_act_modal',['id'=>$key]);
                            },
                            'format' => 'raw'
                        ],
                    ],
                    'pjax' => false,
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                        'options' => [
                            'linkSelector' => 'a[data-pjax!="#pjax-action-container"]'
                        ]
                    ]
                    ]);
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php Pjax::begin(['id' => 'pjax-action-container', /* 'linkSelector' => '#pjax-action-container a', */  'enablePushState' => false, 'enableReplaceState' => false, 'timeout' => 5000]); ?>
                        <div class="box box-solid">
                            <div class="box-header">
                                <h3 class="box-title"><?= Yii::t('yii', 'Выберите действие'); ?></h3>
                                <div class="box-tools pull-right"><?php // $this->render('//modules/payment/views/payment/_modal',['client_id'=>$model->id,'model'=>new Payment]);           ?></div>
                            </div>
                            <div class="box-body">
                                <p><?= Yii::t('payment', 'Select contract to show payments'); ?></p>
                            </div>
                        </div>
                        <?php Pjax::end(); ?>
    </div>
</div>
