<?php

/**
 * @var $model Ticket instance
 * @var $this View
 *  */
use yii\helpers\Html;
use yii\grid\GridView;
//use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

$js = <<< 'SCRIPT'
$(function () { 
    $("[data-toggle='popover']").popover();
});
SCRIPT;
$this->registerJs($js);
?>
<?php
//Prepare params for print button. Add to print URL grid-filter params
$print_ticket_params = Yii::$app->request->queryParams;
$print_ticket_params['print'] = true;
array_unshift($print_ticket_params, '/ticket/ticket/printtickets');
?>
<?=
'<div  class="box box-primary">' . GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "<div class=\"box-header\">"
    . '<h3 class="box-title">Талоны по договору № ' . $model->contract->number . '</h3>'
    . "<div class=\"box-tools\">"
    . "<div class=\"pull-left\">"
    . $this->render('//modules/ticket/views/ticket/_modal', ['model' => $model])
    . '&nbsp;'
    . Html::tag('span', '', ['class' => 'btn btn-primary btn-sm ion ion-printer', 'title' => Yii::t('ticket', 'Print Tickets'), 'id' => 'printTickets', 'data-url' => Url::to($print_ticket_params)])
    . "</div>"
    . "{pager}</div></div>"
    . "<div class=\"box-body no-padding\">{items}</div>",
    'tableOptions' => ['class' => 'table table-stripped'],
    'pager' => [
        'options' => [
            'class' => 'pagination pagination-sm pull-right no-margin'
        ],
        'maxButtonCount' => 5
    ],
    'tableOptions' => ['class' => 'table table-stripped'],
    'id' => 'ticket-grid',
    'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id',
            'options' => ['class' => 'col-md-1']
        ],
//            'contract_id',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d.m.Y'],
            'filter' => DatePicker::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'attribute2' => 'to_date',
                        'options' => ['placeholder' => 'Дата от'],
                        'options2' => ['placeholder' => 'Дата до'],
                        'type' => DatePicker::TYPE_RANGE,
                        'separator' => '-',
                        'pluginOptions' => [
                            'format' => 'dd.mm.yyyy',
                            'autoclose' => true,
                        ]
                    ]
            ),
            'options' => ['class' => 'col-md-4']
        ],
        [
            'value' => function($model) {
                $value = $this->render('_close_modal', ['model' => $model]);
                $value = $model->closed_at !== null ? Yii::$app->formatter->asDate($model->closed_at, 'php:d.m.Y') . $value : $value;
                return $value;
            },
                    'format' => 'raw',
                    'attribute' => 'closed_at',
                    'filter' => false
        ],
        [
            'value' => function($model) {
                return $model->getFormattedServices('withprice');
            },
            'header' => Yii::t('ticket', 'Services'),
            'options' => ['class' => 'col-md-3']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return $this->render('_deletePopover', ['url' => $url]);
                }
                    ]
                ]
            ],
        ]) . '</div>';
?>