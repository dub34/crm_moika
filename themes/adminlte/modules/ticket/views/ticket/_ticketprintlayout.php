<?php 
use yii\helpers\Html;
/**
 * 
 * Printing ticket in loop for count($model)
 * 
 * @var $model Ticket model;
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
    .right {
        text-align: right;
    }
    .table p {
        margin: 1px;
        line-height: 1em;
    }
    .table{
        border-collapse: collapse;
        font-size: 11px;
        margin: 0;
        padding: 0;
    }
    .bold {
        font-weight: bold;
        font-size: 12px;
        font-family: inherit
    }
    .border,.border tr, .border td{
        border: 1px solid #000;
    }
    .inside-border,.inside-border tr, .inside-border td
    {
        border: none;
    }
    .small{
        font-size: 10px
    }
</style>
<?php
for ($i=0; $i<count($model);$i++)
{
    if ($i!==0 && ($i % 4) == 0)
    {
        echo '<pagebreak>';
    }
    echo $this->render('_ticketprintview',['model'=>$model[$i],'office'=>$office]);
    if ($i+1 !== count($model))
    {
        echo Html::tag('hr','',['style'=>"border-top: dotted 1px;"]);
    }
    
}
?>