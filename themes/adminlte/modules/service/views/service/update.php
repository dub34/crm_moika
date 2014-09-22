<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\service\models\Service $model
 */

$this->title = 'Редактировать услугу: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="service-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
