<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\employee\models\EmployeeSearch $searchModel
 */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name:ntext',
//            [
//                'attribute'=>'office_id',
//                'value'=>function ($model){ return $model->office->name;}
//            ],
//            'sign_img:ntext',

            [
				'class' => 'yii\grid\ActionColumn',
			],
        ],
    ]); ?>

</div>
