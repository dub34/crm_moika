<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use \app\modules\employee\models\Position;

/**
 * @var yii\web\View $this
 * @var app\modules\office\models\Office $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-view">
	<p>
		<?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?=
		Html::a('Удалить', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		])
		?>
	</p>

	<?=
	DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'name',
			'register_address:ntext',
			'bank_name:ntext',
			'bank_code',
			'payment_account',
			'unp',
			'okpo',
			'telephone:ntext',
			'fax:ntext',
			'email:email',
			[
				'attribute'=>'logo',
				'value' => $model->logo ? Html::img('/' . $model->logo, ['width' => 100]) : '',
				'format'=>'raw'
			],
		],
	])
	?>

</div>
<h3>Сотрудники филиала</h3>

<?php \yii\bootstrap\Modal::begin([
	'header' => '<h4>Добавить сотрудника</h4>',
	'toggleButton' => ['label' => 'click me', 'class' => 'btn btn-sm btn-success'],
]);
?>

<div class="row">
	<div class="col-md-12">
		<?= Html::beginForm(['/office/office/add-employees','id'=>$model->id]); ?>
		<div class="row">

			<div class="col-md-1">
			</div>
			<div class="col-md-3">
				ФИО
			</div>
			<div class="col-md-4">
				Должность
			</div>

			<div class="col-md-1">
				Подписывает док-ты
			</div>
		</div>
		<?php foreach (\app\modules\employee\models\Employee::find()->all() as $employee) : ?>

			<div class="row">

				<div class="col-md-1">
					<?= Html::checkbox("Employee[$employee->id]", array_key_exists($employee->id,$employees),['class'=>'employee-set']); ?>
				</div>
				<div class="col-md-3">
					<?= $employee->name; ?>
				</div>
				<div class="col-md-4">
					<?= Html::dropDownList("Employee[$employee->id][position]", $employee->position->position->id,
						\yii\helpers\ArrayHelper::map(Position::find()->all(), 'id', 'name'),[
							'class'=>'form-control input-sm',
//							'prompt'=>'Выберите должность',
							'disabled'=>!array_key_exists($employee->id,$employees)
						]); ?>
				</div>
				<div class="col-md-1">
					<?= Html::radio("signdoc",$employee->id==$signDoc,['value'=>$employee->id, 'disabled'=>!array_key_exists($employee->id,$employees)]); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php Html::endForm();?>
	</div>
</div>
<hr>
<?= Html::submitButton('Сохранить',['class'=>'btn btn-success'])?>
<?php
\yii\bootstrap\Modal::end();
?>
<div class="office-employees">
	<?=
	GridView::widget([
		'dataProvider' => $employeesDataProvider,
		'summary' => false,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name:ntext',
			[
				'class' => 'yii\grid\ActionColumn',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']),
							'/employee/employee/view/' . $model->id);
					},
					'update' => function ($url, $model) {
						return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']),
							'/employee/employee/update/' . $model->id);
					},
					'delete' => function ($url, $model) {
						return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']),
							'/employee/employee/delete/' . $model->id);
					},
				]
			]
		],
	]);
	?>
</div>
