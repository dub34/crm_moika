<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'register_address:ntext',
            [
               'attribute'=> 'chief.name',
                'label'=>$model->getAttributeLabel('chief_name')
            ],
            [
               'attribute'=> 'glbuh.name',
                'label'=>$model->getAttributeLabel('glbuh_name')
            ],
            [
               'attribute'=> 'checkbuh.name',
                'label'=>$model->getAttributeLabel('check_buh_name')
            ],
            'bank_name:ntext',
            'bank_code',
            'payment_account',
            'unp',
            'okpo',
            'telephone:ntext',
            'fax:ntext',
            'email:email',
			[
				'attribute'=>'logo',
                'value' => $model->logo ? Html::img('/' . $model->logo, ['width' => 100]) : '',
				'format'=>'raw'
			]
        ],
    ])
    ?>

</div>
<h3>Сотрудники филиала</h3>
<div class="office-employees">
    <?=
    GridView::widget([
        'dataProvider' => $employeesDataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'view' => function ($url,$model) {
                        return  Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-eye-open']), '/employee/employee/view/'.$model->id);
                    },
                    'update' => function ($url,$model) {
                        return  Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-pencil']), '/employee/employee/update/'.$model->id);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-trash']), '/employee/employee/delete/'.$model->id);
                    },
                ]
            ]
        ],
    ]);
    ?>
</div>
