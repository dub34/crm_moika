<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\data\ActiveDataProvider;
use app\modules\contract\models\Contract;
use app\modules\payment\models\Payment;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var app\modules\client\models\Client $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view row">
    <?php
    $details = '<div class="box box-primary">'
            . '<div class="box-header">'
            . "<div class=\"box-tools\"><p class=\"pull-left\">"
            . Html::a(Html::tag('span', '', ['class' => 'ion ion-edit']), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary font-white', 'title' => Yii::t('client', 'Update client')])
            . '&nbsp;'
            . Html::a(Html::tag('span', '', ['class' => 'ion ion-trash-a']), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger font-white', 'title' => Yii::t('client', 'Delete client'), 'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
        ]]) . "</p>"
            . "</div></div>"
            . DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'register_address:ntext',
                    'post_address:ntext',
                    'chief_name:ntext',
                    'chief_post:ntext',
                    'bank_name:ntext',
                    'bank_code',
                    'payment_account',
                    'unp',
                    'okpo',
                    'fax',
                    'telephone',
                    'email:email',
                    'responsible_person:ntext',
                ],
            ]) . '</div>';
    $contracts = '<div class="box box-primary">' . GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => Contract::find()->where(['client_id' => $model->id]),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                        ]),
                'layout' => "<div class=\"box-header\">"
                . "<div class=\"box-tools\"><p class=\"pull-left\">"
                . Html::a(Html::tag('span', '', ['class' => 'ion ion-briefcase']), ['/contract/contract/create', 'Contract[client_id]' => $model->id], ['class' => 'btn btn-sm btn-success font-white', 'title' => Yii::t('contract', 'Create contract')])
                . "</p>{pager}</div></div>"
                . "<div class=\"box-body no-padding\">{items}</div>",
                'tableOptions' => ['class' => 'table table-stripped'],
                'pager' => [
                    'options' => [
                        'class' => 'pagination pagination-sm pull-right no-margin'
                    ],
                    'maxButtonCount' => 5
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
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function($action, $model, $key, $index) {
                    return '/contract/contract/' . $action . '/' . $key;
                },
                        'options' => ['class' => 'col-md-2']
                    ],
                    [
                        'value' => function($model, $key, $index) {
                    return Html::a(Html::tag('span', '', ['class' => 'ion ion-chevron-right']), '#', ['class' => 'load-contracts', 'data-container' => 'contract_payments', 'data-url' => Url::to('/payment/payment'), 'data-id' => $model->id]);
                },
                        'format' => 'raw'
                    ]
                ],
            ]) . '</div>';
    ?>
    <div class="col-md-6">
        <div class="nav-tabs-custom">
            <?=
            Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('client', 'Details'),
                        'content' => $details,
                        'options' => ['id' => 'details'],
                    ],
                    [
                        'label' => Yii::t('contract', 'Contracts'),
                        'content' => $contracts,
                        'options' => ['id' => 'contracts'],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?= Yii::t('payment', 'Show Payments'); ?></h3>
            </div>
            <div class="box-body">
                <?php Pjax::begin(['id' => 'contract_payments', 'clientOptions' => ['history'=>false,'replace' => false]]); ?>
                <p><?= Yii::t('payment', 'Select contract to show payments'); ?></p>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>


</div>
