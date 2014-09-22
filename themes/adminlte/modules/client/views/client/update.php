<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\client\models\Client $model
 */

$this->title = 'Редактировать клиента: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="client-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
