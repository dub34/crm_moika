<?php
use yii\helpers\Html;
?>
<a href="#" class="deleteBtn" data-toggle="popover"
    rel="popover" data-pjax="0"
    data-placement="left"
    data-trigger="focus"
    tabindex="0"
    data-content='<?=
    Html::a('Удалить',$url,['class'=>'btn btn-primary confirm-delete','data-pjax'=>0]).
    '&nbsp'.
    Html::a('Отменить',"#",['class'=>'btn btn-default','data-pjax'=>0])
?>'
    data-html="true" data-original-title="Подтвердите удаление">
    <?= Html::tag('span','',['class'=>'glyphicon glyphicon-trash']);?>
</a>
