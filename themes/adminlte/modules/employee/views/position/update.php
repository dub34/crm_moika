<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 */

$this->title = 'Редактировать должность: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Должности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="position-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
