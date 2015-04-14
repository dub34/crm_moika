<?php

namespace app\modules\office\controllers;

use Yii;
use app\modules\office\models\Office;
use app\modules\office\models\OfficeSearch;
use app\modules\employee\models\EmployeeSearch;
use app\components\controllers\Controller;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * OfficeController implements the CRUD actions for Office model.
 */
class OfficeController extends Controller
{
	public function behaviors()
	{
		$behaviors = [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
		return array_merge(parent::behaviors(), $behaviors);
	}

	/**
	 * Lists all Office models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new OfficeSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single Office model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$office = $this->findModel($id);
		$EmployeesearchModel = new EmployeeSearch;
		$EmployeesearchModel->office_id = $id;

		$employees = $office->getEmployees();
//		var_dump($employees);
		$signDoc = \Yii::$app->settings->get('signdoc' . $id, 'employee');
		$employeesDataProvider = $EmployeesearchModel->search([]);
		return $this->render('view', [
			'model' => $office,
			'employeesDataProvider' => $employeesDataProvider,
			'employees' => $employees,
			'signDoc' => $signDoc
		]);
	}

	/**
	 * Creates a new Office model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Office;
		$loaded = $model->load(Yii::$app->request->post());
		if ($loaded && $model->validate()) {
			if ($model->save()) {

				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Office model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Office model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionAddEmployees($id)
	{

		$employees = \Yii::$app->request->post('Employee');
		$positions = ArrayHelper::getColumn($employees, 'position');

		array_walk($employees, function (&$element, $key, $id) {
			$element = [$key, $id];

		}, $id);


		array_walk($positions, function (&$element, $key, $id) {
			if ($element != '') {
				$element = [$key, $element, $id];
			} else {
				return;
			}
		}, $id);
		$dbCommand = \Yii::$app->db->createCommand();
		$dbCommand->delete('office_has_employee', ['office_id' => $id])->execute();
		$dbCommand->delete('employee_has_position',
			['employee_id' => array_keys($employees), 'office_id' => $id])->execute();
		if (is_array($employees) && count($employees) > 0) {
			$dbCommand->batchInsert('office_has_employee', ['employee_id', 'office_id'], $employees)->execute();
		}
		if (is_array($positions) && count($positions) > 0) {
			$dbCommand->batchInsert('employee_has_position', ['employee_id', 'position_id', 'office_id'],
				$positions)->execute();
		}

		if (($signDocId = \Yii::$app->request->post('signdoc'))) {
			\Yii::$app->settings->set('signdoc' . $id, $signDocId, 'employee', 'integer');
		}else
		{
			\Yii::$app->settings->delete('signdoc' . $id, 'employee');
		}
		$this->redirect(['/office/office/view', 'id' => $id]);


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
		if (($model = Office::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
