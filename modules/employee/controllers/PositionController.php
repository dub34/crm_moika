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
use yii\web\NotFoundHttpException;

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
			return $this->redirect(['index']);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}


	/**
	 * Finds the Office model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Office the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Position::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

} 