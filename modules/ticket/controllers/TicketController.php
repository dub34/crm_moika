<?php

namespace app\modules\ticket\controllers;

use app\components\controllers\Controller;
use app\modules\service\models\Service;
use app\modules\service\models\ServiceHistory;
use app\modules\ticket\models\SearchTicket;
use app\modules\ticket\models\Ticket;
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{

    public function behaviors()
    {
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
    public function actionIndex()
    {
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

    public function actionLoadticketsgrid($id)
    {
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

    public function actionPrintact()
    {
        $searchModel = new SearchTicket;

        $tickets = $searchModel->search(Yii::$app->request->queryParams)->getModels();

        $payments = Ticket::getPaymentsForAct($searchModel->closed_at, $searchModel->closed_to_date,
            $searchModel->contract_id);

        $pdf = new \mPDF('',
            'A4',//format
            '14',//font-s
            '',//font
            10,//m-l
            10,//m-r
            10,//m-t
            10,//m-b
            0,//m-header
            0);//m-footer
        ob_start();
        echo $this->renderAjax('_act_layout',
            ['tickets' => $tickets, 'model' => $searchModel, 'payments' => $payments]);
        $html = ob_get_contents();
        ob_end_clean();
        $pdf->WriteHTML($html);
        $filename = 'act-' . $searchModel->closed_at . '-' . $searchModel->closed_to_date . '.pdf';
        $pdf->Output($filename, 'I');
        Yii::$app->end();
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionView($id, $contract_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $contract_id),
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
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
                $connection->createCommand()->batchInsert(Ticket::tableName(), ['created_at', 'contract_id'],
                    $tickets)->execute();
                $transaction->commit();
                Yii::$app->session->setFlash('ticket_save_success', Yii::t('ticket', 'Tickets saved'));
                $model->ticket_count = $model_params['ticket_count'];
                $model->contract_id = $model_params['contract_id'];
                array_key_exists('email', $model_params) ? $model->email = $model_params['email'] : '';
                \Yii::$app->response->format = 'json';
                return [
                    'message' => 'success',
                    'data' => $this->renderAjax('_count_form', [
                        'model' => $model,
                    ])
                ];

//                $this->redirect('/ticket/ticket/printtickets');
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('ticket_save_error', $e->getMessage());
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('_count_form', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Show tickets printPage
     */
    public function actionPrinttickets()
    {
        $limit = Yii::$app->request->get('ticket_count', null);
        $contract_id = Yii::$app->request->get('contract_id', null);
        $office = new \app\modules\office\models\Office();
        $office = $office->defaultOffice;
        $tmpl_data = ['office' => $office];
        if (null !== $limit && null !== $contract_id) {
            $model = Ticket::find()->where(['contract_id' => $contract_id])->orderBy('id DESC')->limit($limit)->all();
            $tmpl_data['model'] = $model;
            $tmpl_data['smodel'] = $model;
        } else {
            $searchModel = new SearchTicket();
            $model = $searchModel->search(Yii::$app->request->queryParams)->getModels();
            $tmpl_data['model'] = $model;
            $tmpl_data['smodel'] = $searchModel;
        }
        $file = $this->savePdf($tmpl_data);
        if (Yii::$app->request->get('email', null) !== null && Yii::$app->request->get('email', null) !== '') {
            $to = html_entity_decode(Yii::$app->request->get('email'));
            $mail = Yii::$app->mailer->compose()// message body becomes a view rendering result here
            ->setFrom(Yii::$app->settings->get('main.AdminEmail'))
                ->setTo($to)
                ->setSubject('Талоны ' . $office->name . ' ' . date('d.m.Y'))
                ->attach($file)
                ->send();
        }
        header('content-type:application/pdf');
        header('Content-disposition: inline; filename="' . $file . '"');
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Pragma: public');
        echo file_get_contents($file);
        if (file_exists($file)) {
            unlink($file);
        }
        Yii::$app->end();
    }

    //Save pdf to file
    //return save $filename or false on negative saving;
    public function savePdf($data = [])
    {
        $pdf = new \mPDF('',
            'A4',//format
            '12',//font-s
            '',//font
            5,//m-l
            5,//m-r
            5,//m-t
            5,//m-b
            0,//m-header
            0);//m-footer);
        ob_start();
        echo $this->renderAjax('_ticketprintlayout', $data);
        $html = ob_get_contents();
        ob_end_clean();
        $pdf->WriteHTML($html);
        $filename = 'files/tickets/tickets-dog-' . $data['smodel']->contract->number . '-' . date('d-m-Y-H-i-s') . '.pdf';
        $pdf->Output($filename, 'F');
        return file_exists($filename) ? $filename : false;
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionUpdate($id, $contract_id)
    {

        $model = $this->findModel($id);
        $model->scenario = "close_ticket";
        if ($model->load(Yii::$app->request->post())) {
            if (strtotime($model->created_at) !== strtotime(Yii::$app->formatter->asDate($model->oldAttributes['created_at'],
                    'php:d.m.Y'))
            ) {
                $model->scenario = "update";
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('ticket', 'Ticket saved'));
                if (Yii::$app->request->isAjax) {
                    \Yii::$app->response->format = 'json';
                    return [
                        'message' => 'success',
                        'data' => $this->renderAjax('_close_form', [
                            'model' => $model,
                        ])
                    ];
                } else {
                    return $this->redirect(['view', 'id' => $model->id, 'contract_id' => $model->contract_id]);
                }
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_close_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\web\HttpException
     */

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (!Yii::$app->request->isAjax) {
                return $this->redirect(['index']);
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['message' => 'success'];
            }
        } else {
            throw new \yii\web\HttpException('Ошибка при удалении', '500');
        }
        $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */

    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
