<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\contract\models\SearchContract;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\client\models\ClientSearch $searchModel
 */
$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">
    
    <div class="box box-primary">
        <!--<div class="box-body no-padding">-->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'summary' => false,
                'layout' => "<div class=\"box-header\">"
                . "<div class=\"box-tools\"><p class=\"pull-left\">".Html::a(Html::tag('span','',['class'=>'ion ion-person-add']),['create'], ['class' => 'btn btn-success font-white','title'=>Yii::t('client','Create client')])."</p>{pager}</div></div>"
                . "<div class=\"box-body no-padding\">{items}</div>",
                'tableOptions' => ['class' => 'table table-stripped'],
                'pager'=>[
                    'options'=>[
                        'class'=>'pagination pagination-sm pull-right no-margin'
                    ],
                   'maxButtonCount'=>5
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
                    'name',
//            'register_address:ntext',
//            'post_address:ntext',
//            'chief_name:ntext',
                    // 'chief_post:ntext',
                    // 'bank_name:ntext',
                    // 'bank_code',
                    // 'payment_account',
                    // 'unp',
                    // 'okpo',
                    // 'fax',
                    [
                        'value'=>function($model){
                            return Html::a(Html::tag('span',$model->contractsCount,['class'=>'badge bg-light-blue']),['/contract/contract','SearchContract[client_id]'=>$model->id]);
                        },
                        'format'=>'html',
                        'header'=>Yii::t('contract','Contracts')
                    ],
                    [
                        'attribute' => 'telephone',
                        'options' => ['class' => 'col-md-1']
                    ],
                    [
                    
                        'attribute' => 'email',
                        'options' => ['class' => 'col-md-1'],
                        'format'=>'email'
                    ],
                    // 'responsible_person:ntext',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

        <!--</div>-->
    </div>
</div>
