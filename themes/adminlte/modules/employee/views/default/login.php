<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-box" id="login-box">
    <div class="header"><?= Html::encode($this->title) ?></div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
    ]);
    ?>
    <div class="body bg-gray">
            <?= $form->field($model, 'employeename')->textInput(['placeholder'=> 'username']); ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'password']); ?>
            <?=
            $form->field($model, 'rememberMe', [
                'template' => "{input}<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox()
            ?>
    </div>
    <div class="footer">                                                               
<?= Html::submitButton('Login', ['class' => 'btn bg-olive btn-block', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>