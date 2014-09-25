<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\contract\models\Contract $model
 */

$this->title = Yii::t('contract', 'Update contract') . $model->number;
$this->params['breadcrumbs'][] = ['label' => Yii::t('contract', 'Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('contract', 'Update');
?>
<div class="contract-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
