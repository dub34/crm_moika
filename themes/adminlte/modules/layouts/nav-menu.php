<?php
use yii\helpers\Html;
/* *
 * 
 * Navigation menu
 */
?>

<ul class="sidebar-menu">           
    <!--<li class="treeview">-->
    <li>
        <?= Html::a('Филиалы','office/office'); ?>
        
<!--        <a href="">
            <i class="fa fa-bar-chart-o"></i>
            <span>Офисы</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>-->
<!--        <ul class="treeview-menu">
            <li><a href="../charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
            <li><a href="../charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
            <li><a href="../charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
        </ul>-->
    </li>
    <li>
        <?= Html::a('Сотрудники','employee/employee'); ?>
    </li>
    <li>
        <?= Html::a('Клиенты','client/client'); ?>
    </li>
    <li>
        <?= Html::a('Услуги','service/service'); ?>
    </li>
</ul>