<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\client\models\ClientSearch $searchModel
 */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="client-index">
    <p>
        <?= Html::a('Создать клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
             'telephone',
             'email:email',
            // 'responsible_person:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
