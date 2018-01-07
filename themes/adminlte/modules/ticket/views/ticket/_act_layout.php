<?php

use app\components\helpers\Helpers;
use app\modules\contract\models\CalculationModel;
use app\modules\contract\models\Contract;
use app\modules\office\models\Office;
use yii\helpers\Html;

/**
 * Print act modal window with form
 * @var $contract Contract
 * @var $model CalculationModel
 */
//$summ = []; //сумма стоимости всех услуг по всем талонам в акте
//$summNDS = [];
//$summBezNDS = [];
\app\assets\PrintActAsset::register($this);
$office = (new Office)->defaultOffice;
?>

<!--<div id="non-printable"></div>-->


<table class="table">
    <tr>
        <td width="50%" style="text-align: center">
            <?php if ($office->logo != null): ?>
            <?= Html::img('@web/' . $office->logo, ['width' => '200']); ?></td>
        <?php endif; ?>
        <td style="text-align: center">
            <?= Html::tag('h4', $office->name); ?>

            <p>Юридический адрес: <?= $office->register_address; ?></p>

            <p>УНП <?= $office->unp; ?> ОКПО <?= $office->okpo; ?></p>

            <p>р/с <?= $office->payment_account; ?> в <?= $office->bank_name; ?>, код <?= $office->bank_code; ?></p>

            <p>тел. <?= $office->telephone; ?>, <?= $office->fax; ?></p>
        </td>
    </tr>
</table>
<hr style="background: blue;">

<div class="row center">
    <div class="col-xs-12"><h2>Акт № <?= $model->actNumber; ?> от <?= $model->actDate; ?></h2></div>
</div>
<div class="row center">
    <div class="col-xs-12">
        <p> Выполненных работ <?= $office->name; ?></p>

        <p>по обслуживанию автомобилей согласно договору № <?= $contract->number; ?>
            от <?= $contract->created_at; ?></p>
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
<table class="table">
    <tr>
        <td><strong> Сальдо расчетов на начало периода:</strong></td>
        <td class="right">
            <strong><?= Yii::$app->formatter->asDecimal($model->startSaldo, 2); ?> руб.</strong></td>
    </tr>
</table>
<hr/>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th class="col-xs-1">№ талона/<br/>ведомости</th>
                <th class="col-xs-1">№ программы</th>
                <th>Кол-во</th>
                <th class="col-xs-2">Дата</th>
                <th>Сумма без НДС,<br/>руб</th>
                <th class="col-xs-1">Ставка НДС,<br/>%</th>
                <th>Сумма НДС,<br/>руб</th>
                <th>Сумма с НДС,<br/>руб</th>
            </tr>
            <?php foreach ($model->getTickets() as $ticket): ?>
                <?php foreach ($ticket->services as $service): ?>
                    <tr>
                        <td><?= $service->ticket_id; ?></td>
                        <td><?= $service->name; ?></td>
                        <td><?= $service->count; ?></td>
                        <td><?= $ticket->closed_at; ?></td>
                        <td><?= Yii::$app->formatter->asDecimal($service->priceWithoutNDS, 2); ?></td>
                        <td><?= $service->nds; ?></td>
                        <td><?= Yii::$app->formatter->asDecimal($service->priceNDS, 2); ?></td>
                        <td><?= Yii::$app->formatter->asDecimal($service->sum_price, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">Итого оказано услуг:</td>
                <td><strong><?= Yii::$app->formatter->asDecimal($model->serviceSummWithoutNDS, 2) ?></strong></td>
                <td>&nbsp;</td>
                <td><strong><?= Yii::$app->formatter->asDecimal($model->serviceSummNDS, 2); ?></strong></td>
                <td><strong><?= Yii::$app->formatter->asDecimal($model->serviceSumm, 2); ?></strong></td>
            </tr>
        </table>
    </div>
</div>
<table class="table">
    <tr>
        <td>
            Оплачено за период:
        </td>
        <td class="right">
            <table class="table">
                <?php foreach ($model->payments as $payment): ?>
                    <tr>
                        <td width="100" class="left">
                            <?= $payment->created_at; ?>
                        </td>
                        <td>
                            <?= Yii::$app->formatter->asDecimal($payment->payment_sum, 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
</table>

<hr/>
<?php
//$end_saldo = (int)$startBalance - (int)$summ + \app\modules\ticket\models\Ticket::getPaymentSumm($payments);
?>

<table class="table">
    <tr>
        <td><strong>Сальдо расчетов на конец периода </strong></td>
        <td class="right"><strong><?= Yii::$app->formatter->asDecimal($model->endSaldo, 2); ?> руб.</strong></td>
    </tr>
</table>
<hr/>
<table class="table">
    <tr>
        <td><h5><strong>Итого к оплате за расчетный период:</strong></h5></td>
        <td class="right"><h5>
                <strong><?= ((int)$model->endSaldo < 0) ? Yii::$app->formatter->asDecimal($model->endSaldo * -1, 2) : 0; ?>
                    руб.
            </h5></strong></td>
    </tr>
</table>
<table class="table">
    <tr>
        <td class="center"><p>Исполнитель</p></td>
        <td class="center"><p>Клиент</p></td>
    </tr>
    <tr>
        <td class="center"><p><strong><?= $office->name; ?></strong></p></td>
        <td class="center"><p><strong><?= $contract->client->name; ?></strong></p></td>
    </tr>
    <tr>
        <td class="center">
            <br/>
            <br/>
            <?php if ($office->signPerson) :
                $sign = $office->signPerson;
                $sign->office_id = $office->id;
                ?>
                <p><?= $sign->position->position->name; ?>_____________________/<?= $office->signPerson->name; ?>/</p>

            <?php endif; ?>
        </td>
        <td class="center">
            <br/>
            <br/>

            <p>_____________________/<?= $contract->client->chief_name; ?>/</p></td>
    </tr>
</table>
<br/>
<br/>
<div class="row">
    <div class="col-xs-12"><p>Претензии по настоящему акту просим предъявлять до 18 числа следующего месяца. В противном
            случае акт будет принят к исполнению.</p>
    </div>
</div>
