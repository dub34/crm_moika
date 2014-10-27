<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/**
 * Print act modal window with form
 * @var $model instance of Contract model class
 */
if ($model->id){
    $src=Url::to(['/payment/payment/printinvoice','id'=>$model->id,'contract_id'=>$model->contract_id]);
}else 
    $src='';

?>
<?php 
//Modal::begin([
//    'id'=>'printInvoice',
//    'header'=>'<h3>'.Yii::t('payment','Create invoice').'</h3>',
//    'size'=>  Modal::SIZE_DEFAULT,
//    'options'=>['data-url'=>Url::to(['/payment/payment/loadpaymentgrid','contract_id'=>$model->contract_id])],
//    
//    'toggleButton'=> ['label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-tasks']),
//        'title' => Yii::t('payment', 'Create invoice'), 
//        'class' => 'btn btn-primary btn-sm',
//        ],
//]);
    ?>
<button class="btn btn-primary btn-sm" id="invoiceMdlOpen" data-toggle="modal" data-target="#printInvoice" title="<?= Yii::t('payment', 'Create invoice');?>"><span class="glyphicon glyphicon-tasks"></span></button>

<!-- Modal -->
<div class="modal fade" id="printInvoice" tabindex="-1" role="dialog" aria-labelledby="invoiceCreateDlgLabel" aria-hidden="true" data-url="<?= Url::to(['/payment/payment/printinvoice','contract_id'=>$model->contract_id])?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="invoiceCreateDlgLabel"><?= Yii::t('payment', 'Create invoice'); ?></h4>
      </div>
      <div class="modal-body">
                    <?php $form = ActiveForm::begin(['action' => Url::to('/payment/payment/printinvoice'), 'id' => 'printInvoiceForm', 'options' => ['class' => 'printInvoiceForm']]); ?>

          <?= $form->field($model, 'contract_id', ['template' => '{input}'])->hiddenInput(); ?>

          <?= $form->field($model, 'payment_sum'); ?>

          <?= Html::submitButton(Yii::t('ticket', 'Form invoice'), ['class' => 'btn btn-success', 'data-pjax' => 0]); ?>

          <?php ActiveForm::end(); ?>

          <br />

          <!--<div id="frame">-->
              <?= Html::button('Распечатать', ['class' => 'btn btn-primary', 'id' => 'invoicePrintBtn', 'style' => 'display: none;']); ?>

              <!--<iframe class="invoiceFrame" id="invoicePrintFrame" src="<?= $src; ?>" name ="invoicePrintFrame" width="100%" height="0 ?>"></iframe>-->
          <!--</div>-->
          
      </div>
    </div>
  </div>
</div>





<?php // Modal::end();?>