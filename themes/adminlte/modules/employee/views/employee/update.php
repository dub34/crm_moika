<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 */

$this->title = 'Редактировать сотрудника: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id, 'office_id' => $model->office_id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="employee-update">

    <?= $this->render('_form', [
        'model' => $model,
        'offices'=>$offices
    ]) ?>

</div>
