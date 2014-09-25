<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\contract\models\Contract $model
 */

$this->title = Yii::t('contract', 'Create contract');
$this->params['breadcrumbs'][] = ['label' => Yii::t('contract', 'Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
