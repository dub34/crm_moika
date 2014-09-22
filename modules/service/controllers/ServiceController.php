<?php

namespace app\modules\service\controllers;

use Yii;
use app\modules\service\models\Service;
use app\modules\service\models\ServiceSearch;
use app\modules\service\models\ServiceHistory;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
{
    public function behaviors()
    {
        $behaviors=[
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
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Service model.
     * @param integer $id
     * @param integer $service_history_id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
//        $versions = $model->getAllVersions();
        return $this->render('view', [
            'model' => $model,
//            'allVersions'=>$versions
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service;
        $history_model = new ServiceHistory;

        if ($model->load(Yii::$app->request->post())) {
            
            
            if ($model->validate())
            {
//                $history_model->save();
//                $model->service_history_id = $history_model->id;
                $model->save();
//                $model->link('ServiceHistory',$history_model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                'model' => $model,
                'history_model'=>$history_model
            ]);
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $service_history_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $history_model = $model->serviceHistory;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'history_model'=>$history_model
            ]);
        }
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $service_history_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $service_history_id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
