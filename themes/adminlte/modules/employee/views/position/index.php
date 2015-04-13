<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\employee\models\Position $searchModel
 */

$this->title = 'Должности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Создать должность', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'summary'=>false,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name:ntext',
			[
				'class' => 'yii\grid\ActionColumn',
			],
		],
	]); ?>

</div>
