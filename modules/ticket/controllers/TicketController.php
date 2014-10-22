<?php

namespace app\modules\ticket\controllers;

use Yii;
use app\modules\ticket\models\Ticket;
use app\modules\ticket\models\SearchTicket;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller {

    public function behaviors() {
        $behaviors = [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post','get'],
//                ],
//            ],
        ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchTicket();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPjax) {
            return $this->renderAjax('_grid', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionLoadticketsgrid($id) {
        $searchModel = new SearchTicket();
        $dataProvider = $searchModel->search(array_merge(Yii::$app->request->queryParams, ['id' => $id]));
        $model = new Ticket;
        $model::populateRecord($model, ['contract_id' => $id]);
        return $this->renderAjax('_grid', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model
        ]);
    }

    public function actionPrintact() {
        $searchModel = new SearchTicket;

        $tickets = $searchModel->search(Yii::$app->request->queryParams)->getModels();

        $payments = Ticket::getPaymentsForAct($searchModel->closed_at, $searchModel->closed_to_date, $searchModel->contract_id);

        return $this->renderAjax('_act_layout', ['tickets' => $tickets, 'model' => $searchModel, 'payments' => $payments]);
    }

    /**
     * Displays a single Ticket model.
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
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Ticket();
        $model->contract_id = Yii::$app->request->get('contract_id');
        $model_params = Yii::$app->request->post('Ticket', null);
        $ticket = [
            date('Y-m-d H:i:s'),
            $model_params['contract_id']
        ];
        if ($model_params !== null && array_key_exists('ticket_count', $model_params)) {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $tickets = array_fill(0, $model_params['ticket_count'], $ticket);
                $connection->createCommand()->batchInsert(Ticket::tableName(), ['created_at', 'contract_id'], $tickets)->execute();
                $transaction->commit();
                Yii::$app->session->setFlash('ticket_save_success', Yii::t('ticket', 'Tickets saved'));
                $model->ticket_count = $model_params['ticket_count'];
                $model->contract_id = $model_params['contract_id'];

                \Yii::$app->response->format = 'json';
                return ['message' => 'success', 'data' => $this->renderAjax('_count_form', [
                        'model' => $model,
                ])];

//                $this->redirect('/ticket/ticket/printtickets');
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('ticket_save_error', $e->message);
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('_count_form', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                                //                            'client_id' => (null !== $model->contract) ? $model->contract->client_id : null
                ]);
            }
        }
    }

    /**
     * Show tickets printPage
     */
    public function actionPrinttickets() {
        $limit = Yii::$app->request->get('ticket_count', null);
        $contract_id = Yii::$app->request->get('contract_id', null);
        if (null !== $limit && null !== $contract_id) {
            $model = Ticket::find()->where(['contract_id' => $contract_id])->orderBy('id DESC')->limit($limit)->all();
            return $this->renderAjax('_ticketprintlayout', ['model' => $model]);
        } else {
            $searchModel = new SearchTicket();
            $model = $searchModel->search(Yii::$app->request->queryParams)->getModels();
            return $this->renderAjax('_ticketprintlayout', ['model' => $model]);
        }

        throw new NotFoundHttpException('No tickets to print', '400');
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionUpdate($id, $contract_id) {

        $model = $this->findModel($id);
        $model->scenario = "update";
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('ticket', 'Ticket saved'));
            if (Yii::$app->request->isAjax) {
                \Yii::$app->response->format = 'json';
                return ['message' => 'success', 'data' => $this->renderAjax('_close_form', [
                        'model' => $model,
                ])];
            } else
                return $this->redirect(['view', 'id' => $model->id, 'contract_id' => $model->contract_id]);
        }
        else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('_close_form', [
                            'model' => $model,
                ]);
            } else
                return $this->render('update', [
                            'model' => $model,
                ]);
        }
    }

    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->delete()){
            if (!Yii::$app->request->isAjax)
                return $this->redirect(['index']);
            else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['message' => 'success'];
            }
        } else {
            throw new \yii\web\HttpException('Ошибка при удалении', '500');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $contract_id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
