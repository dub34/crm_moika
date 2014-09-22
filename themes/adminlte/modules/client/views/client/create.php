<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\client\models\Client $model
 */

$this->title = 'Создать клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
