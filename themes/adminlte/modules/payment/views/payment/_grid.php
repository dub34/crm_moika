<?php

use yii\helpers\Html;
use yii\grid\GridView;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\PaymentSearch $searchModel
 */
$js = <<< 'SCRIPT'
$(function () { 
    $("[data-toggle='popover']").popover();
});
SCRIPT;
$this->registerJs($js);
?>
<!--<div id="pjax-action-container">-->
<?=
'<div  class="box box-primary">' . GridView::widget([
    'dataProvider' => $paymentDP,
    'id'=>'payments-grid',
    'layout' => "<div class=\"box-header\">"
    . '<h3 class="box-title">Платежи по договору '.$model->contract->number.'</h3>'
    . "<div class=\"box-tools\">"
            . "<div class=\"pull-left\">"
            . $this->render('//modules/payment/views/payment/_modal',['model'=>$model])
            .'&nbsp'
            . $this->renderAjax('//modules/payment/views/payment/_invoice_modal',['model'=>$model])
            . "</div>"
    .'<div class="pull-right">'
    .  Html::tag('button','',['class'=>'glyphicon glyphicon-info-sign text-success','data-toggle'=>'popover','data-content'=>Yii::$app->settings->get('payment.paymentCreateNotice'),'data-placement'=>'bottom'])
    . '</div>'
    . "</div></div>{pager}"
    . "<div class=\"box-body no-padding\">{items}</div>",
    'tableOptions' => ['class' => 'table table-striped'],
    'pager' => [
        'options' => [
            'class' => 'pagination pagination-sm pull-right no-margin'
        ],
        'maxButtonCount' => 5
    ],
    'columns' => [
        'id',
        [
            'attribute'=>'payment_sum',
            'value'=> function($model){ return app\components\helpers\Helpers::roundUp($model->payment_sum); },
            'format'=>'integer'
            
        ],
        'created_at',
        [
            'value'=>function($model, $key, $index){
                return Html::tag('span','',['class'=>$model->status == 1?'glyphicon glyphicon-ok text-success':'glyphicon glyphicon-ban-circle text-muted','title'=>$model->status==1?Yii::t('payment','active'):Yii::t('payment','nonactive')]);
            },
            'format'=>'raw',
        ],
//        [
//            'value'=>function($model, $key, $index){
//                return Html::radio('payments',false,['value'=>$key['id']]);
//            },
//            'format'=>'raw'
//        ],
        [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{show_invoice}{delete}',
        'buttons' => [
            'delete' => function ($url, $model, $key) {                
                return $this->render('_deletePopover',['url'=>$url]);
            },
            'show_invoice'=>function($url,$model,$key){
                return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-tasks','title'=>Yii::t('payment','View invoice')]),['/payment/payment/printinvoice','id'=>$model->id],['data-pjax'=>0,'class'=>'viewInvoice']);
            }
        ]
]
    ],
]) . '</div>';
?>
    <!--</div>-->