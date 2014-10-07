<?php
/**
 * @var $model Ticket instance
 * @var $this View
 *  */


use yii\helpers\Html;
use yii\grid\GridView;
//use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker
?>
<div id="pjax-action-container">
    <?=
    '<div  class="box box-primary">' . GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "<div class=\"box-header\">"
        . '<h3 class="box-title">Талоны по договору № '.$model->contract->number.'</h3>'
        . "<div class=\"box-tools\">"
        . "<p class=\"pull-left\">"
        . $this->render('//modules/ticket/views/ticket/_modal', ['model' => $model])
        . "</p>"
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
//        'striped'=>true,
//        'bordered'=>false,
//        'pjax'=>true,
//        'pjaxSettings'=>[
//            'options'=>[
//                'enableReplaceState'=>false,
//                'enablePushState'=>false,
//            ]
//        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'contract_id',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y H:i'],
                'filter' => DatePicker::widget(
                        [
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'attribute2' => 'to_date',
                            'options' => ['placeholder' => 'Дата от'],
                            'options2' => ['placeholder' => 'Дата до'],
                            'type' => DatePicker::TYPE_RANGE,
                            'separator'=>'-',
                            'pluginOptions' => [
                                'format' => 'dd.mm.yyyy',
                                'autoclose' => true,
                            ]
                        ]
                ),
                'options' => ['class' => 'col-md-4']
            ],
            [
                'value'=>function($model){
                    return $model->closed_at!==null?Yii::$app->formatter->asDate($model->closed_at,'php:d.m.Y H:i'):$this->render('_close_modal',['model'=>$model]);
                },
                'format'=>'raw',
                'attribute'=>'closed_at',
                'filter'=>false
            ],
            [
                'value'=>function($model){
                    return implode(',', \yii\helpers\ArrayHelper::map($model->services, 'id', 'name'));
                },
                'header'=>Yii::t('ticket','Services')
            ]
                        
//                        'priznak',
        // 'pometka',
//                        ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) . '</div>';
    ?>
</div>