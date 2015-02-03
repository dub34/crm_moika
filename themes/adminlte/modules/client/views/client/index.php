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
                    . "<div class=\"box-tools\"><p class=\"pull-left\">" . Html::a(Html::tag('span', '',
                        ['class' => 'ion ion-person-add']), ['create'],
                        ['class' => 'btn btn-success font-white', 'title' => Yii::t('client', 'Create client')])
                    . '&nbsp;' . Html::a(Html::tag('span', '', ['class' => 'ion ion-trash-a']),
                        ['', 'showDeleted' => $showDeleted ? 'off' : 'on'], [
                            'class' => $showDeleted ? 'btn btn-default active' : 'btn btn-default',
                            'title' => Yii::t('client', 'Show deleted')
                        ])
                    . "</p>{pager}</div></div>"
                . "<div class=\"box-body no-padding\">{items}</div>",
                'tableOptions' => ['class' => 'table table-stripped'],
                'pager'=>[
                    'options'=>[
                        'class'=>'pagination pagination-sm pull-right no-margin'
                    ],
                   'maxButtonCount'=>5
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['class' => ($model->is_deleted) ? 'bg-danger' : null];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
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
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'restore' => function ($url, $model, $key) {
                                return $model->is_deleted ? Html::a('', $url, [
                                    'class' => 'glyphicon glyphicon-repeat',
                                    'data-confirm' => 'Вы уверены, что хотите восстановить этот элемент?',
                                    'data-method' => 'post',
                                    'data-pjax' => 0,
                                    'title' => 'Восстановить'
                                ]) : '';
                            },
                            'delete' => function ($url, $model, $key) {
                                return (!$model->is_deleted) ? Html::a('', $url, [
                                    'class' => 'glyphicon glyphicon-trash',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'data-method' => 'post',
                                    'data-pjax' => 0
                                ]) : '';
                            }
                        ],
                        'template' => '{view}{update}{delete}{restore}'
                    ],
                ],
            ]);
            ?>
    </div>
</div>
