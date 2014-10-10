<?php

use yii\helpers\Html;

/* *
 * 
 * Navigation menu
 */
?>

<ul class="sidebar-menu">           
    <li class="treeview">
        <?= Html::a('Справочники'); ?>
        <ul class="treeview-menu">
            <li><?= Html::a('Филиалы', '/office/office'); ?></li>
            <li><?= Html::a(Yii::t('employee','Employees'), '/employee/employee'); ?></li>
            <li><?= Html::a(Yii::t('client','Clients'), '/client/client'); ?></li>
            <li><?= Html::a('Услуги', '/service/service'); ?></li>
        </ul>
    </li>
    
    <li><?= Html::a('<i class="glyphicon glyphicon-briefcase"></i><span>Договоры</span>', '/contract/contract'); ?></li>
</ul>

                                