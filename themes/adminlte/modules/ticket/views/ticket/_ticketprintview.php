<?php
/**
 * Ticket view
 *
 * @var \app\modules\ticket\models\Ticket $model
 * 
 * 
 *  */

?>
<table class="table border">
    <tr>
        <td><?= $office->register_address?></td>
        <td><?= $office->register_address?></td>
    </tr>
    <tr class="center bold">
        <td class="center bold">
            <p>ТАЛОН (форма Т-1) №<?= $model->id;?></p>
            <p>НА МОЙКУ АВТОМОБИЛЯ</p>
        </td>
        <td class="center bold">
            <p>КВИТАНЦИЯ К ТАЛОНУ (форма Т-1) №<?= $model->id;?></p>
            <p>НА МОЙКУ АВТОМОБИЛЯ</p>
        </td>
    </tr>
    <tr>
        <td><?= $office->name; ?> (УНП <?= $office->unp?>)</td>
        <td><?= $office->name; ?> (УНП <?= $office->unp?>)</td>
    </tr>
    <tr>
        <td>
            <p>Заказчик <?= $model->contract->client->name;?></p>
            <p>Договор № <?= $model->contract->number?> от <?= $model->contract->created_at; ?></p>
            <p>Автомобиль___________________________________________</p>
            <p class="small">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(марка, гос. номер, тип)</p>
        </td>
        <td>
            <p>Заказчик <?= $model->contract->client->name;?></p>
            <p>Договор № <?= $model->contract->number?> от <?= $model->contract->created_at; ?></p>
            <p>Автомобиль___________________________________________</p>
            <p class="small">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(марка, гос. номер, тип)</p>
        </td>
    </tr>
    <tr>
        <td>
            № пр. <?= $model->programms?>
            <br />
        </td>
        <td>
            № пр. <?= $model->programms?>
            <br />
        </td>
    </tr>
    <tr>
        <td>
            <table class="table inside-border">
                <tr style="border-bottom:1px solid #000;">
                    <td>Стоимость, руб</td>
                    <td style="border-left:1px solid #000;">Ставка НДС, %</td>
                    <td style="border-left:1px solid #000;">Сумма НДС, руб.</td>
                    <td style="border-left:1px solid #000;">Всего с НДС, руб.</td>
                </tr>
                <tr>
                    <td><?= Yii::$app->formatter->asDecimal($model->summWithoutNDS, 2); ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->nds; ?></td>
                    <td style="border-left:1px solid #000;"><?= Yii::$app->formatter->asDecimal($model->summNDS, 2); ?></td>
                    <td style="border-left:1px solid #000;"><?= Yii::$app->formatter->asDecimal($model->summ, 2);?></td>
                </tr>
            </table>
        </td>
        <td>
            <table class="table inside-border">
                <tr style="border-bottom:1px solid #000;">
                    <td>Стоимость, руб</td>
                    <td style="border-left:1px solid #000;">Ставка НДС, %</td>
                    <td style="border-left:1px solid #000;">Сумма НДС, руб.</td>
                    <td style="border-left:1px solid #000;">Всего с НДС, руб.</td>
                </tr>
                <tr>
                    <td><?= Yii::$app->formatter->asDecimal($model->summWithoutNDS, 2); ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($model->summWithoutNDS, 2); ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->nds; ?></td>
                    <td style="border-left:1px solid #000;"><?= Yii::$app->formatter->asDecimal($model->summNDS, 2); ?></td>
                    <td style="border-left:1px solid #000;"><?= Yii::$app->formatter->asDecimal($model->summ, 2); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="table inside-border">
                <tr>
                    <td width="150">Дата <?= $model->closed_at;?></td>
                    <td>Заказчик_________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="small center">(подпись)</td>
                </tr>
                <tr>
                    <td width="150">Исполнитель__________________</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_______________________________</td>
                </tr>
                <tr>
                    <td class="small right">(должность,подпись)</td>
                    <td class="small center">(ФИО)</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="table inside-border">
                <tr>
                    <td width="150">Дата <?= $model->closed_at;?></td>
                    <td>Заказчик_________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="small center">(подпись)</td>
                </tr>
                <tr>
                    <td width="150">Исполнитель__________________</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_______________________________</td>
                </tr>
                <tr>
                    <td class="small right">(должность,подпись)</td>
                    <td class="small center">(ФИО)</td>
                </tr>
            </table>
        </td>
    </tr>
</table>