<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php

Modal::begin([
    'header' => '<h2>' . Yii::t('ticket', 'Create ticket') . '</h2>',
    'id' => 'ticketCreateDlg',
    'toggleButton' => ['label' => Html::tag('span', '', ['class' => 'ion ion-document', 'title' => Yii::t('ticket', 'Create ticket')]), 'data-url'=>Url::to(['/ticket/ticket/create','contract_id'=>$model->contract_id]), 'id'=>'ticketMdlOpen','class' => 'btn btn-success btn-sm font-white'],
]);
?>

<?php
Modal::end();
?>
    