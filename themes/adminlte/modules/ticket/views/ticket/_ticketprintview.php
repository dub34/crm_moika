<?php
/**
 * Ticket view
 * 
 * @var $model instance of Ticket model
 * 
 * 
 *  */

?>
<table class="table border">
    <tr>
        <td>220007 г. Минск, ул. Володько, 9  Тел. 297-38-98</td>
        <td>220007 г. Минск, ул. Володько, 9  Тел. 297-38-98</td>
    </tr>
    <tr class="center bold">
        <td>
            <p>ТАЛОН (форма Т-1) №<?= $model->id;?></p>
            <p>НА МОЙКУ АВТОМОБИЛЯ</p>
        </td>
        <td>
            <p>КВИТАНЦИЯ К ТАЛОНУ (форма Т-1) №<?= $model->id;?></p>
            <p>НА МОЙКУ АВТОМОБИЛЯ</p>
        </td>
    </tr>
    <tr>
        <td>ООО "Автопромсервис-Плюс" (УНП 10137376)</td>
        <td>ООО "Автопромсервис-Плюс" (УНП 10137376)</td>
    </tr>
    <tr>
        <td>
            <p>Заказчик <?= $model->contract->client->name;?></p>
            <p>Договор № <?= $model->contract->number?> от <?= $model->contract->created_at; ?></p>
            <p>Автомобиль___________________________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(марка, гос. номер, тип)</small></p>
        </td>
        <td>
            <p>Заказчик <?= $model->contract->client->name;?></p>
            <p>Договор № <?= $model->contract->number?> от <?= $model->contract->created_at; ?></p>
            <p>Автомобиль___________________________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(марка, гос. номер, тип)</small></p>
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
                    <td><?= $model->summWithoutNDS; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->nds; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->summNDS; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->summ;?></td>
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
                    <td><?= $model->summWithoutNDS; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->nds; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->summNDS; ?></td>
                    <td style="border-left:1px solid #000;"><?= $model->summ;?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><p>Дата <?= $model->closed_at;?>&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Заказчик________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(подпись)</small></p>
            <p>Исполнитель__________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(должность,подпись)</small>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(ФИО)</small></p>
            
        </td>
       <td><p>Дата <?= $model->closed_at;?>&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Заказчик________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(подпись)</small></p>
            <p>Исполнитель__________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(должность,подпись)</small>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>(ФИО)</small></p>
            
        </td>
    </tr>
</table>