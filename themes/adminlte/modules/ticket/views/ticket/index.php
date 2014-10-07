<?php

use yii\helpers\Html;
use yii\bootstrap\Button;
use yii\grid\GridView;
use app\modules\contract\models\Contract;
use app\modules\contract\models\SearchContract;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ticket\models\SearchTicket */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('ticket', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= Yii::t('ticket', 'Tickets'); ?></h3>
                <div class="box-tools pull-right">
                    <?php // Button::widget(['options'=>['class'=>'btn-success btn-sm'],'encodeLabel'=>false,'label'=>'<span class="ion ion-briefcase"></span>']); ?>
                </div>
            </div>
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-stripped'],
                    'pager' => [
                        'options' => [
                            'class' => 'pagination pagination-sm pull-right no-margin'
                        ],
                        'maxButtonCount' => 5
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'created_at',
                        'closed_at',
//                        'priznak',
                        // 'pometka',
//                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>