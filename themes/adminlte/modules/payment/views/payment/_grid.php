<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\PaymentSearch $searchModel
 */
?>
<?php // Pjax::begin(['id' =>'pjax-action-container']); ?>
<div id="pjax-action-container">
<?=
'<div  class="box box-primary">' . GridView::widget([
    'dataProvider' => $paymentDP,
    'id'=>'payments-grid',
    'layout' => "<div class=\"box-header\">"
    . '<h3 class="box-title">Платежи по договору '.$model->contract->number.'</h3>'
    . "<div class=\"box-tools\">"
            . "<p class=\"pull-left\">"
            . $this->render('//modules/payment/views/payment/_modal',['model'=>$model])
            .'&nbsp'
            . $this->renderAjax('//modules/payment/views/payment/_invoice_modal',['model'=>$model])
            . "</p>"
    . "{pager}</div></div>"
    . "<div class=\"box-body no-padding\">{items}</div>",
    'tableOptions' => ['class' => 'table table-striped'],
    'pager' => [
        'options' => [
            'class' => 'pagination pagination-sm pull-right no-margin'
        ],
        'maxButtonCount' => 5
    ],
//            'pager' => [
//                'options' => [
//                    'class' => 'pagination pagination-sm pull-right no-margin'
//                ],
//                'maxButtonCount' => 5
//            ],
    'columns' => [
        'id',
        'payment_sum:integer',
        'created_at',
        
//        'contract_id'
        [
            'value'=>function($model, $key, $index){
                return Html::tag('span','',['class'=>$model->status == 1?'glyphicon glyphicon-ok text-success':'glyphicon glyphicon-ban-circle text-muted','title'=>$model->status==1?Yii::t('payment','active'):Yii::t('payment','nonactive')]);
            },
            'format'=>'raw',
        ],
        [
            'value'=>function($model, $key, $index){
                return Html::radio('payments',false,['value'=>$key['id']]);
            },
            'format'=>'raw'
        ],
    ],
]) . '</div>';
?>
    </div>
<?php // Pjax::end(); ?>