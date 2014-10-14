<?php

namespace app\modules\service\controllers;

use Yii;
use app\modules\service\models\Service;
use app\modules\service\models\ServiceSearch;
use app\modules\service\models\ServiceHistory;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;
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
        $model->nds = Yii::$app->settings->get('.nds');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate())
            {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                'model' => $model,
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
//        $model->nds = Yii::$app->settings->get('nds');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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

    public function actionGetactualversionsbydate(){
        $out = [];
        if (Yii::$app->request->post('date') && Yii::$app->request->post('ticket_id'))
        {
            $services = ServiceHistory::getActualVersionsByDate(Yii::$app->request->post('date'));
            if (count($services)>0)
            {
                foreach ($services as $service)
                {
                    $out[]=Html::tag('option',$service->name,['value'=>$service->id]);
                }
            }
//            \Yii::$app->response->format = 'json';
            return implode('',$out);
            
        }
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
