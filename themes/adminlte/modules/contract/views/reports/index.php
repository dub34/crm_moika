<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use yii\grid\GridView;
$script = <<<SKRIPT
        
        var data ={$chart_data};
        if (data.length>0){
var line = new Morris.Line({
                    element: 'clients-payments',
                    resize: true,
                    data: data,
                    xkey: 'closed_at',
                    ykeys: ['summ'],
                    labels: ['{$model->getAttributeLabel('summ')}'],
                    xLabels:'month',
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });
    }
SKRIPT;
\app\assets\MorrisChartAsset::register($this);
$this->registerJs($script);
$this->title = Yii::t('contract', 'All clients payments');
?>


<div class="box box-primary">
    <div class="box-body chart-responsive">
        <?php $form = ActiveForm::begin(['method' => 'POST', 'options' => ['style' => 'width:400px;']]); ?>
        <?=
        FieldRange::widget([
            'label' => Yii::t('contract', 'Select date range'),
            'form' => $form,
            'model' => $model,
            'id' => 'client_payment_d_r',
            'attribute1' => 'date_start',
            'attribute2' => 'date_stop',
            'useAddons' => false,
            'separator' => '&larr;&rarr;',
            'type' => FieldRange::INPUT_DATE,
            'widgetOptions1' => [
                'pluginOptions' => ['autoclose' => true, 'format' => 'dd.mm.yyyy'],
            ],
            'widgetOptions2' => [
                'pluginOptions' => ['autoclose' => true, 'format' => 'dd.mm.yyyy'],
            ],
        ]);
        ?>
        <?= Html::submitButton(Yii::t('contract', 'Get'), ['class' => 'btn btn-success']); ?>
        <?php ActiveForm::end(); ?>
        <?php if (count(json_decode($chart_data))>0):?>
        <div class="chart" id="clients-payments" style="height: 300px;"></div>

        <br />
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'layout' => '<div>{pager}</div>{items}',
            'pager' => [
                'options' => [
                    'class' => 'pagination pagination-sm pull-right no-margin'
                ],
                'maxButtonCount' => 5
            ],
            'columns' => [
                [
                    'attribute' => 'closed_at',
                    'options' => ['class' => 'col-md-1'],
                    'header'=>Yii::t('yii','Месяц'),
                    'format'=>['date', 'php:m-Y']
                ],
                [
                    'attribute' => 'summ',
                    'options' => ['class' => 'col-md-1'],
                    'header'=>$model->getAttributeLabel('summ'),
                    'format'=>'integer'
                ],
            ]
        ]);
        ?>
        <?php else:?>
        <h3><?= Yii::t('yii','Нет данных');?></h3>
        <?php endif;?>
    </div>
</div>