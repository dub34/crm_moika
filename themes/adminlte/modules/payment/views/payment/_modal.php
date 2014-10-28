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

//Modal::begin([
//    'header' => '<h2>' . Yii::t('payment', 'Create payment') . '</h2>',
//    'id' => 'paymentCreateDlg',
//    'toggleButton' => ['label' => Html::tag('span', '', ['class' => 'ion ion-clipboard', 'title' => Yii::t('payment', 'Create payment')]), 'class' => 'btn btn-success btn-sm font-white'],
//]);
?>
<button class="btn btn-success btn-sm" id="paymentMdlOpen" title="<?= Yii::t('payment', 'Create payment');?>" data-url="<?= Url::to(['/payment/payment/create','contract_id'=>$model->contract_id]);?>"><span class="ion ion-clipboard"></span></button>

<!-- Modal -->
<div class="modal fade" id="paymentCreateDlg" tabindex="-1" role="dialog" aria-labelledby="paymentCreateDlgLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="paymentCreateDlgLabel"><?= Yii::t('payment', 'Create payment');?></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>

<?php
//Modal::end();
?>
    