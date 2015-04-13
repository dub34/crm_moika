<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 02.04.15
 * Time: 17:28
 */

namespace app\modules\employee\controllers;


use app\components\controllers\Controller;
use app\modules\employee\models\Position;

class PositionController extends Controller
{

	public function actionIndex(){
		$searchModel = new Position();
		$dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);


		return $this->render('index');
	}

	public function actionCreate()
	{
		$model = new Position();
		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
//				'offices'=>$offices
			]);
		}
	}

} 