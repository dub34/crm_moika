<?php

namespace app\modules\office\controllers;

use Yii;
use app\modules\office\models\Office;
use app\modules\office\models\OfficeSearch;
use app\modules\employee\models\EmployeeSearch;
use app\components\controllers\Controller;
use yii\base\Exception;
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
        $behaviors= [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(),$behaviors);
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
		$office =$this->findModel($id);
        $EmployeesearchModel = new EmployeeSearch;
		$EmployeesearchModel->office_id = $id;
		$employees = $office->getEmployees();
//		var_dump($employees);
        $employeesDataProvider = $EmployeesearchModel->search([]);
        return $this->render('view', [
            'model' => $office,
            'employeesDataProvider'=>$employeesDataProvider,
			'employees'=>$employees
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
		}
		else {
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
