<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\employee\models\Employee $model
 */

$this->title = 'Создать сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <?= $this->render('_form', [
        'model' => $model,
        'offices'=>$offices
    ]) ?>

</div>
