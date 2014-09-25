<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\contract\models\SearchContract $searchModel
 */
$this->title = Yii::t('contract', 'Contracts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-index">
    <div class="box box-primary">
        <div class="box-body no-padding">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "<div class=\"box-header\">"
                . "<div class=\"box-tools\"><p class=\"pull-left\">".Html::a(Html::tag('span','',['class'=>'ion ion-briefcase']),['create'], ['class' => 'btn btn-success font-white','title'=>Yii::t('contract', 'Create contract')])."</p>{pager}</div></div>"
                . "<div class=\"box-body no-padding\">{items}</div>",
                'tableOptions' => ['class' => 'table table-stripped'],
                 'pager'=>[
                    'options'=>[
                        'class'=>'pagination pagination-sm pull-right no-margin'
                    ],
                   'maxButtonCount'=>5
                ],
                'columns' => [
                    [
                        'attribute' => 'number',
                        'options' => ['class' => 'col-md-1']
                    ],
                    [
                        'attribute' => 'client',
                        'value' => 'client.name',
                    ],
                    'created_at',
                    ['class' => 'yii\grid\ActionColumn', 'options' => ['class' => 'col-md-1']],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
