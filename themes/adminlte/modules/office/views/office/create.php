<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 */

$this->title = 'Создать филиал';
$this->params['breadcrumbs'][] = ['label' => 'Offices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
