<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 */

$this->title = 'Создать должность';
$this->params['breadcrumbs'][] = ['label' => 'Должности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
