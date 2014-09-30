<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;


/**
 * @var yii\web\View $this
 * @var app\modules\payment\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php

Modal::begin([
    'header' => '<h2>' . Yii::t('payment', 'Create payment') . '</h2>',
    'id' => 'paymentCreateDlg',
    'toggleButton' => ['label' => Html::tag('span', '', ['class' => 'ion ion-clipboard', 'title' => Yii::t('payment', 'Create payment')]), 'class' => 'btn btn-success btn-sm font-white'],
]);
?>
<?= $this->render('_form', ['model' => $model, 'client_id' => $client_id]); ?>

<?php

Modal::end();
?>
    