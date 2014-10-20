<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\field\FieldRange;
use yii\helpers\Url;
use app\modules\office\models\Office;

/**
 * Print act modal window with form
 * @var $model instance of Contract model class
 */
//$summ = []; //сумма стоимости всех услуг по всем талонам в акте
//$summNDS = [];
//$summBezNDS = [];
//\app\assets\PrintActAsset::register($this);
$office = new Office;
$office = $office->defaultOffice;
?>

<div id="non-printable"><?= Html::button('Распечатать', ["id" => 'printBtn', 'onclick' => 'window.print()']); ?></div>



<div class="row">
    <div class="col-xs-6">Поставщик <?= $office->name; ?>
        <p>Его адрес <?= $office->register_address; ?> УНП <?= $office->unp; ?> ОКПО <?= $office->okpo; ?></p>
        <p>тел. <?= $office->telephone; ?>, факс <?= $office->fax; ?></p>
        <p>р/с <?= $office->payment_account; ?> в <?= $office->bank_name; ?></p>
        <p>Код <?= $office->bank_code; ?> г. Минск, п-т. Независимости, 87-а</p>
        <p>УНП <?= $office->unp; ?> ОКПО <?= $office->okpo; ?></p>
    </div>
    <div class="col-xs-6 ">
        <h4>Счет-фактура №___</h4>
        <p>от ___-________________201__г.</p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <p>Грузоотправитель <?= $office->name; ?></p>
        <p>Ст. отправления г.Минск</p>
    </div>
    <div class="col-xs-6">
        <table class="table">
            <tr>
                <td>Склад</td>
                <td>№ опер.</td>
                <td>Шифр покуп.</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
