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
    'layout' => "<div class=\"box-header\">"
    . '<h3 class="box-title">Платежи по договору '.$model->contract->number.'</h3>'
    . "<div class=\"box-tools\">"
            . "<p class=\"pull-left\">"
                . $this->render('//modules/payment/views/payment/_modal',['model'=>$model])
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
//            'pager' => [
//                'options' => [
//                    'class' => 'pagination pagination-sm pull-right no-margin'
//                ],
//                'maxButtonCount' => 5
//            ],
    'columns' => [
        'id',
        'payment_sum',
        'created_at',
//        'contract_id'
//                [
//                    'class' => 'yii\grid\ActionColumn',
//                    'urlCreator' => function($action, $model, $key, $index) {
//                return '/contract/contract/' . $action . '/' . $key;
//            },
//                    'options' => ['class' => 'col-md-2']
//                ],
    ],
]) . '</div>';
?>
    </div>
<?php // Pjax::end(); ?>