<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\field\FieldRange;
use yii\helpers\Url;
/**
 * Print act modal window with form
 * @var $model instance of Contract model class
 */
$summ=[]; //сумма стоимости всех услуг по всем талонам в акте
$summNDS = [];
$summBezNDS = [];
?>
<p>Баланс на начало периода: <strong><?= $startBalance = app\modules\ticket\models\Ticket::getStartBalance($model->contract_id,$model->closed_at);?></strong></p>
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
<?php foreach ($tickets as $ticket):?>
    <?php foreach ($ticket->services as $service):?>
    <?php 
        $summ[]=$service->price; 
        $summNDS[] = $service->priceNDS;
        $summBezNDS[] = $service->priceWithoutNDS;
    ?>
        <tr>
            <td><?= $service->ticket_id;?></td>
            <td><?= $service->name;?></td>
            <td><?= $ticket->closed_at;?></td>
            <td><?= $service->priceWithoutNDS;?></td>
            <td><?= $service->nds;?></td>
            <td><?= $service->priceNDS;?></td>
            <td><?= $service->price;?></td>
        </tr>    
    <?php endforeach; ?>
<?php endforeach; ?>
        <tr>
            <td colspan="3">Итого оказано услуг: </td>
            <td><strong><?= array_sum($summBezNDS)?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?= array_sum($summNDS);?></strong></td>
            <td><strong><?= $summ = array_sum($summ);?></strong></td>
        </tr>
</table>
<table class="table">
    <tr>
        <td rowspan="<?= count($payments)+1;?>">Оплачено за период:</td>
    </tr>
    
    <?php foreach ($payments as $payment):?>
    <tr>
        <td><?= $payment->created_at;?></td>
        <td colspan="3">&nbsp;</td>
        <td><?= $payment->payment_sum;?></td>
    </tr>
    <?php endforeach;?>
    <tr>
        <td colspan="5">Итого оплачено за период</td>
        <td><strong><?= $summPayments = array_sum(\yii\helpers\ArrayHelper::getColumn($payments, 'payment_sum')) ?></strong></td>
    </tr>
    <tr>
        <td colspan="5">Сальдо расчетов на конец периода</td>
        <td><strong><?= (int)$startBalance-(int)$summ+(int)$summPayments;?></strong></td>
    </tr>
</table>