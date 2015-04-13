<?php

namespace app\modules\employee\controllers;

use Yii;
use app\modules\employee\models\Employee;
use app\modules\employee\models\EmployeeSearch;
use app\components\controllers\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    public function behaviors()
    {
        $behaviors =[
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @param integer $office_id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$offices = ArrayHelper::map($model->offices,'id','name');
        return $this->render('view', [
            'model' => $model,
            'offices'=>implode(', ',$offices)
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee;
        $offices = \app\modules\office\models\Office::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'office_id' => $model->office_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'offices'=>$offices
            ]);
        }
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $office_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $offices = \app\modules\office\models\Office::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'office_id' => $model->office_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'offices'=>$offices
            ]);
        }
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $office_id
     * @return mixed
     */
    public function actionDelete($id, $office_id)
    {
        $this->findModel($id, $office_id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $office_id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
