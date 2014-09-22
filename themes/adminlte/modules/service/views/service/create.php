<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\service\models\Service $model
 */

$this->title = 'Создать услугу';
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">

    <?= $this->render('_form', [
        'model' => $model,
        'history_model'=>$history_model
    ]) ?>

</div>
