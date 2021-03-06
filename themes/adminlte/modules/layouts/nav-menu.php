<?php

use yii\helpers\Html;

/* *
 * 
 * Navigation menu
 */
?>

<ul class="sidebar-menu">           
    <li class="treeview">
        <?= Html::a('<span class="glyphicon glyphicon-folder-open"></span>Справочники'); ?>
        <ul class="treeview-menu">
            <li><?= Html::a('<i class="glyphicon glyphicon-home"></i>Филиалы', '/office/office'); ?></li>
            <li><?= Html::a('<i class="glyphicon glyphicon-user"></i>'.Yii::t('employee','Employees'), '/employee/employee'); ?></li>
            <li><?= Html::a('<i class="glyphicon glyphicon-user"></i>' . Yii::t('employee', 'Должности'),
                    '/employee/position'); ?></li>
            <li><?= Html::a('<i class="ion ion-person-stalker"></i>'.Yii::t('client','Clients'), '/client/client'); ?></li>
            <li><?= Html::a('<i class="ion ion-calendar"></i>'.'Услуги', '/service/service'); ?></li>
        </ul>
    </li>
    <li><?= Html::a('<i class="glyphicon glyphicon-briefcase"></i><span>Договоры</span>', '/contract/contract'); ?></li>
    <li class="treeview"><?= Html::a('<i class="glyphicon glyphicon-signal"></i><span>Отчеты</span>', ''); ?>
        <ul class="treeview-menu">
            <li><?= Html::a('Обороты клиентов за период', '/contract/reports/index'); ?></li>
            <li><?= Html::a('Реестр по клиентам', '/contract/reports/saldo'); ?></li>
        </ul>
    </li>
</ul>

                                