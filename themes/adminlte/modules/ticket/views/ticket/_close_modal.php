<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$script = <<<SKRIPT
    $('#closeticket-{$model->id}').on('shown.bs.modal', function(data){
        $(document).on('beforeSubmit','#closeticket-{$model->id} form',{successHndl:function(){
            $('#closeticket-{$model->id}').modal('hide');
        }},submitForm);
        $(document).on('submit','#closeticket-{$model->id} form',function (e) {e.preventDefault();});
    });
    $('#closeticket-{$model->id}').on('hidden.bs.modal', function(data){
        reloadGrid('.load-tickets',{$model->contract_id});
        $(document).off('beforeSubmit','#closeticket-{$model->id} form');
        $(document).off('submit','#closeticket-{$model->id} form');
        $(document).off('change','#closed_at-{$model->id}');
    });
SKRIPT;

$this->registerJs($script);
?>
<?php

Modal::begin([
    'id' => 'closeticket-' . $model->id,
    'header' => '<h4>' . Yii::t('ticket', 'Edit ticket') . '</h4>',
    'toggleButton' => ['label' => Html::tag('span', '', ['class' => 'ion ion-compose']), 'title' => Yii::t('ticket', 'Edit ticket'), 'class' => 'btn btn-primary btn-xs'],
]);
?>

<?= $this->render('_close_form',['model'=>$model]);?>

<?php Modal::end(); ?>