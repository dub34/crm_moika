<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id, 'office_id' => $model->office_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id, 'office_id' => $model->office_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [                    // the owner name of the model
                'attribute'=>'office_id',
                'value' => $model->office->name,
            ],
            'name:ntext',
//            'sign_img:ntext',
        ],
    ]) ?>

</div>
