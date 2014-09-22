<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 */

$this->title = 'Редактировать филиал: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="office-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
