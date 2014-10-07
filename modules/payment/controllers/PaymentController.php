<?php

namespace app\modules\payment\controllers;

use Yii;
use app\modules\payment\models\Payment;
use app\modules\payment\models\PaymentSearch;
use app\modules\contract\models\Contract;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller {

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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PaymentSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $query = Payment::find();
        if (null !== ($ci = Yii::$app->request->get('contract_id')))
            $query->where = ["contract_id" => $ci];
        $paymentDP = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $model = new Payment;
        if (Yii::$app->request->get('_pjax') == '#contract_payments_pjax_container') {
            return $this->render('_grid', ['paymentDP' => $paymentDP, 'model' => $model]);
        } else {
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'paymentDP' => $paymentDP,
                        'model' => $model
            ]);
        }
    }

    public function actionLoadpaymentgrid($id) {
        $query = Payment::find();
        $query->where = ["contract_id" => $id];
//        $query->orderBy(['created_at' => 'DESC']);
        $paymentDP = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => new \yii\data\Sort([
                'attributes' => [
                    'created_at' => [
                        'asc' => ['created_at' => SORT_ASC],
                        'desc' => ['created_at' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'created_at',
                    ],
                ],
            ])
        ]);
        $model = new Payment;
        $model::populateRecord($model, ['contract_id' => $id]);
        return $this->renderAjax('_grid', ['paymentDP' => $paymentDP, 'model' => $model]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionView($id, $contract_id) {
        return $this->render('view', [
                    'model' => $this->findModel($id, $contract_id),
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Payment;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                $client_id = (null !== $model->contract) ? $model->contract->client_id : null;
                $contract_id = $model->contract_id;
                $model = new Payment;
                $model->contract_id = $contract_id;
                Yii::$app->getSession()->setFlash('payment_save_success', 'Оплата сохранена');
                return $this->renderAjax('create', [
                            'model' => $model,
                            'client_id' => $client_id
                ]);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model::populateRecord($model, ['contract_id' => Yii::$app->request->get('contract_id')]);
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'client_id' => (null !== $model->contract) ? $model->contract->client_id : null
                ]);
            }
        }
    }

//    public function actionLoadform()
//    {
//        return $this->render('_form');
//    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionUpdate($id, $contract_id) {
        $model = $this->findModel($id, $contract_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'contract_id' => $model->contract_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionDelete($id, $contract_id) {
        $this->findModel($id, $contract_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $contract_id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $contract_id) {
        if (($model = Payment::findOne(['id' => $id, 'contract_id' => $contract_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
