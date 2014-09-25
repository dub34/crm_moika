<?php

namespace app\modules\client\controllers;

use Yii;
use app\modules\client\models\Client;
use app\modules\client\models\ClientSearch;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller {

    public function behaviors() {
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
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ClientSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

//        $clients = Client::find()->all();
//        foreach ($clients as $client)
//        {
//            $client->name=  trim($client->name,"'");
//            $client->post_address =  trim($client->post_address,"'");
//            $client->register_address =  trim($client->register_address,"'");
//            $client->chief_name =  trim($client->chief_name,"'");
//            $client->chief_post =  trim($client->chief_post,"'");
//            $client->responsible_person =  trim($client->responsible_person,"'");
//            $client->bank_name =  trim($client->bank_name,"'");
//            $client->email =  trim($client->email,"'");
//            $client->save(false);                       
//        }
//        
//        
//        
//      $row = 1;
//if (($handle = fopen("/home/vkriuchkov/work/table_payment.csv", "r")) !== FALSE) {
//    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
//        $client = new \app\modules\payment\models\Payment;
//        $client->id=$data[0];
//        $client->contract_id=$data[1];
//        $client->payment_sum=$data[2];
//        $client->created_at=$data[3];
//        $client->updated_at=$data[4];
//        try {
//            $client->save(false);
//        } catch (Exception $ex) {
//            echo $client->id.'<br>';
//            continue;
//        }
//        
//       $row++;
//    }
//    fclose($handle);
//}
//        
//       
//        
//        
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Client;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
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
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
