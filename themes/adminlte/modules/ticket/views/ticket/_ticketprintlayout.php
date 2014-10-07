<?php 
use yii\helpers\Html;
/**
 * 
 * Printing ticket in loop for count($model)
 * 
 * @var $model;
 */
?>
<style>
@media print
{
    #non-printable { display: none; }
}
    .center {
        text-align: center;
    }
    .table p {
        margin: 1px;
        line-height: 1em;
    }
    .table{
        border-collapse: collapse;
    }
    .bold {
        font-weight: bold;
        font-size: 14px;
    }
    .border,.border tr, .border td{
        border: 1px solid #000;
    }
    .inside-border,.inside-border tr, .inside-border td
    {
        border: none;
    }
</style>
<div id="printWrap">
    <div id="non-printable"><?= Html::button('Распечатать',["id"=>'printBtn','onclick'=>'window.print()']);?></div>
<?php
for ($i=0; $i<count($model);$i++)
{
    echo $this->render('_ticketprintview',['model'=>$model[$i]]);
    if ($i+1 !== count($model))
    {
        echo Html::tag('hr','',['style'=>"border-top: dotted 1px;"]);
    }
}
?>
</div>