<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 21.04.15
 * Time: 20:40
 * @var \app\modules\contract\models\Contract[] $contracts
 */
use app\components\helpers\Helpers;
use yii\helpers\Html;

\app\assets\PrintActAsset::register($this);
$office = (new \app\modules\office\models\Office())->defaultOffice;
$f = Yii::$app->formatter;
?>

<div class="row">
    <div class="col-xs-12">
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

                    <p>р/с <?= $office->payment_account; ?> в <?= $office->bank_name; ?>,
                        код <?= $office->bank_code; ?></p>

                    <p>тел. <?= $office->telephone; ?>, <?= $office->fax; ?></p>
                </td>
            </tr>
        </table>
        <div class="row center">
            <div class="col-xs-12"><h2>Реестр по клиентам</h2></div>
        </div>
        <div class="row center">
            <div class="col-xs-12">
                <p>(пользовавшихся услугами)</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p>Расчетный период
                    <strong><?= $saldoModel->date_start; ?> &mdash; <?= $saldoModel->date_stop; ?></strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="pull-right"><?= \Yii::$app->formatter->asDate(time(), 'php:d.m.Y'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Наименование клиента</th>
                        <th class="col-xs-1">№ договора</th>
                        <th class="col-xs-1">Дата договора</th>
                        <th>Сумма на начало периода, руб</th>
                        <th>Оплачено за период, руб</th>
                        <th>Сумма за период (с НДС), руб</th>
                        <th>Сумма на конец периода, руб</th>
                    </tr>
                    <?php foreach ($contracts as $contract) : ?>
                        <?php $calculations = new \app\modules\contract\models\CalculationModel(['contract_id' => $contract->id]);
                        $calculations->closed_at = $saldoModel->date_start;
                        $calculations->closed_to_date = $saldoModel->date_stop;
                        ?>
                        <tr>
                            <td><?= $contract->client->name; ?></td>
                            <td><?= $contract->number; ?></td>
                            <td><?= $contract->created_at; ?></td>
                            <td><?= $f->asInteger(Helpers::roundUp($calculations->startSaldo)); ?></td>
                            <td><?= $f->asInteger(Helpers::roundUp($calculations->paymentsSumm)); ?></td>
                            <td><?= $f->asInteger(Helpers::roundUp($calculations->serviceSumm)); ?></td>
                            <td><?= $f->asInteger(Helpers::roundUp($calculations->endSaldo)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>