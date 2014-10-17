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
$summ = []; //сумма стоимости всех услуг по всем талонам в акте
$summNDS = [];
$summBezNDS = [];
\app\assets\PrintActAsset::register($this);
$office = new Office;
$office = $office->defaultOffice;
?>

<div id="non-printable"><?= Html::button('Распечатать', ["id" => 'printBtn', 'onclick' => 'window.print()']); ?></div>



<div class="row">
    <div class="col-xs-6 "><?= Html::img('@web/images/logo.png', ['width' => '250']); ?></div>
    <div class="col-xs-6"> <?= Html::tag('h4', $office->name); ?>
        <p>р/с <?= $office->payment_account; ?> в <?= $office->bank_name; ?></p>
        <p>Код <?= $office->bank_code; ?> УНП <?= $office->unp; ?> ОКПО <?= $office->okpo; ?></p>
        <p>Адрес <?= $office->register_address; ?> УНП <?= $office->unp; ?> ОКПО <?= $office->okpo; ?></p>
        <p>Факс <?= $office->fax; ?> тел. <?= $office->telephone; ?> e-mail <?= $office->email; ?></p>
    </div>
</div>

<div class="row center">
    <div class="col-xs-12"><h2>Акт</h2></div>
</div>
<div class="row center">
    <div class="col-xs-12">
        <p> Выполненных работ <?= $office->name; ?> </p>

            <p>по обслуживанию автомобилей согласно договору № <?= $model->contract->number; ?> от <?= $model->contract->created_at; ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <p>г. Минск</p>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>Расчетный период <strong><?= $model->closed_at; ?> &mdash; <?= $model->closed_to_date; ?></strong></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
      <strong> Сальдо расчетов на начало периода:</strong>
    </div>
    <div class="col-xs-6 right">
        <strong><?= $startBalance = app\modules\ticket\models\Ticket::getStartBalance($model->contract_id, $model->closed_at); ?> руб.</strong>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th class="col-md-1">№ талона/<br />ведомости</th>
                <th class="col-md-1">№ программы</th>
                <th class="col-md-1">Дата</th>
                <th>Сумма без НДС,<br />руб</th>
                <th>Ставка НДС,<br />%</th>
                <th>Сумма НДС,<br />руб</th>
                <th>Сумма с НДС,<br />руб</th>
            </tr>
            <?php foreach ($tickets as $ticket): ?>
                <?php foreach ($ticket->services as $service): ?>
                    <?php
                    $summ[] = $service->price;
                    $summNDS[] = $service->priceNDS;
                    $summBezNDS[] = $service->priceWithoutNDS;
                    ?>
                    <tr>
                        <td><?= $service->ticket_id; ?></td>
                        <td><?= $service->name; ?></td>
                        <td><?= $ticket->closed_at; ?></td>
                        <td><?= $service->priceWithoutNDS; ?></td>
                        <td><?= $service->nds; ?></td>
                        <td><?= $service->priceNDS; ?></td>
                        <td><?= $service->price; ?></td>
                    </tr>    
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Итого оказано услуг: </td>
                <td><strong><?= array_sum($summBezNDS) ?></strong></td>
                <td>&nbsp;</td>
                <td><strong><?= array_sum($summNDS); ?></strong></td>
                <td><strong><?= $summ = array_sum($summ); ?></strong></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        Оплачено за период:
    </div>    
    <div class="col-xs-6">
        <?php foreach ($payments as $payment): ?>
            <div class="row">
                <div class="col-xs-6">
                    <?= $payment->created_at; ?>
                </div>
                <div class="col-xs-6 right">
                    <?= $payment->payment_sum; ?>   
                </div>
            </div>
        <?php endforeach; ?>
    </div>    
</div>    
<hr />
<?php $summPayments = array_sum(\yii\helpers\ArrayHelper::getColumn($payments, 'payment_sum')) ?>
<div class="row">
    <div class="col-xs-6"> <strong>Сальдо расчетов на конец периода </strong></div>
    <div class="col-xs-6 right"><strong><?= (int) $startBalance - (int) $summ + (int) $summPayments; ?> руб.</strong></div>
</div>
<hr />
<div class="row">
    <div class="col-xs-6"> <h5><strong>Итого к оплате за расчетный период:</strong></h5></div>
    <div class="col-xs-6 right"><h5><strong><?= $summPayments; ?> руб.</h5></strong></div>
</div>
<div class="row">
    <div class="col-xs-6 center"><p>Исполнитель</p></div>
    <div class="col-xs-6 center"><p>Клиент</p></div>
</div>
<div class="row">
    <div class="col-xs-6 center"><p><strong><?= $office->name;?></strong></p></div>
    <div class="col-xs-6 center"><p><strong><?= $model->contract->client->name;?></strong></p></div>
</div>
<br />
<div class="row">
    <div class="col-xs-6"><p>Директор_____________________/<?= $office->chief->name;?>/</p></div>
    <div class="col-xs-6"><p>_____________________/<?= $model->contract->client->chief_name;?>/</p></div>
</div>
<br/>
<br/>
<div class="row">
    <div class="col-xs-12"><p>Претензии по настоящему акту просим предъявлять до 18 числа следующего месяца. В противном случае акт будет принят к исполнению.</p>
    <p>Цены указаны согласно прейскуранта (приказ №____ от ____г. )</p></div>
</div>
