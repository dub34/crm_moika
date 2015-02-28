<?php

namespace app\modules\payment\controllers;

use Yii;
use app\modules\payment\models\Payment;
use app\modules\payment\models\PaymentSearch;
use app\components\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use alexgx\phpexcel\PhpExcel;
use app\modules\office\models\Office;
use PHPExcel_IOFactory;
use php_rutils\RUtils;
use app\components\helpers\Helpers;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
{

    public function behaviors()
    {
        $behaviors = [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
        ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
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
            return $this->render('_grid',
                    ['paymentDP' => $paymentDP, 'model' => $model]);
        } else {
            return $this->render('index',
                    [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'paymentDP' => $paymentDP,
                    'model' => $model
            ]);
        }
    }

    public function actionLoadpaymentgrid()
    {
        $id = Yii::$app->request->get('id', Yii::$app->request->post('id', null));
        $contract_id = Yii::$app->request->get('contract_id',
            Yii::$app->request->post('contract_id', null));

        if (!$id && !$contract_id) {
            throw NotFoundHttpException;
        }

        $query = Payment::find();
        $query->where = ["contract_id" => $contract_id];
        $paymentDP = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->settings->get('payment.gridSize'),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
        ]);
        $model = new Payment;
        $model::populateRecord($model,
            ['contract_id' => $contract_id, 'id' => $id]);
//        $model->load(Yii::$app->request->queryParams);
        return $this->renderAjax('_grid',
                ['paymentDP' => $paymentDP, 'model' => $model]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionView($id, $contract_id)
    {
        return $this->render('view',
                [
                'model' => $this->findModel($id, $contract_id),
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id = Yii::$app->request->get('id', Yii::$app->request->post('id', null));
        $contract_id = Yii::$app->request->get('contract_id',
            Yii::$app->request->post('contract_id', null));

        if ($id && $contract_id) $model = $this->findModel($id, $contract_id);
        else {
            $model = new Payment(['scenario' => 'create']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                $contract_id = $model->contract_id;
                $model = new Payment;
                $model->contract_id = $contract_id;
                Yii::$app->getSession()->setFlash('payment_save_success',
                    'Оплата сохранена');
                \Yii::$app->response->format = 'json';
                return ['message' => 'success', 'data' => $this->renderAjax('create',
                        [
                        'model' => $model,
                        ]
                )];
//                return $this->renderAjax('create', [
//                            'model' => $model,
//                ]);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            if ($model->isNewRecord)
                    $model::populateRecord($model,
                    ['contract_id' => Yii::$app->request->get('contract_id')]);
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form',
                        [
                        'model' => $model,
                ]);
            } else {
                return $this->render('create',
                        [
                        'model' => $model,
                ]);
            }
        }
    }

    public function actionPrintinvoice()
    {
        if (!($id = Yii::$app->request->get('id', null))) {
            $model = new Payment(['scenario' => 'create']);
            $model->load(Yii::$app->request->queryParams);
            $model->status = Payment::PAYMENT_NONACTIVE;
            $model->created_at = Yii::$app->formatter->asDate(time(),
                $model->visibleDateFormat);
        } else {
            $model = Payment::findOne([$id]);
        }
        if (!$model->isNewRecord) {
            $this->createExcellReport($model);
        } elseif ($model->save()) {
            $this->createExcellReport($model);
        } else {
            return 'Ошибка при сохранении счета';
        }
    }

    private function createExcellReport(Payment $model)
    {
        if ($model->payment_sum < 0) $model->payment_sum = 0;
        $excel = new PhpExcel;
        $tmpl = $excel->load('files/invoice_new.xls');
        $office = new Office;
        $office = $office->defaultOffice;
//        $nds_value = $model->nds ? $model->nds : Yii::$app->settings->get('nds');
        $summ = $model->calcNds();
        $total_summ = Helpers::roundUp($model->payment_sum);
//        $nds = Helpers::roundUp($model->payment_sum * $nds_value / 100);
//        $sum_bez_nds = Helpers::roundUp($model->payment_sum - $nds);

        $tmpl->setActiveSheetIndex(0)
//            ->setCellValue('J2', $model->id)

            ->setCellValue('A3', 'Поставщик ' . $office->name)
            ->setCellValue('A4', 'его адрес Почт. адрес ' . $office->register_address)
            ->setCellValue('A5',
                'Тел.факс ' . $office->telephone . ', ' . $office->fax)
            ->setCellValue('A7', 'расч.счет ' . $office->payment_account . ' в ' . $office->bank_name)
            ->setCellValue('A8', 'Код ' . $office->bank_code . ' ' . Yii::$app->settings->get('office.bank_address'))
//            ->setCellValue('B8', 'код '.$office->bank_code)
            ->setCellValue('A9', 'УНП ' . $office->unp . ' ОКПО ' . $office->okpo)
            ->setCellValue('A10', 'Грузоотправитель ' . $office->name)
            ->setCellValue('A11', 'Ст. отправления г.Минск')
            ->setCellValue('E3', 'СЧЕТ-ФАКТУРА №' . $model->id)
            ->setCellValue('E5', 'от ' . Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y'))
//            ->setCellValue('H6',Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y'))
            ->setCellValue('B14', $model->contract->client->name)
            ->setCellValue('E19', Yii::$app->formatter->asInteger($summ->nds_value))
            ->setCellValue('D19', Yii::$app->formatter->asInteger($summ->sum))
//            ->setCellValue('E15', RUtils::numeral()->getRubles($summ->sum))
            ->setCellValue('B24', RUtils::numeral()->getRubles($summ->nds_sum))
            ->setCellValue('B26', RUtils::numeral()->getRubles(Helpers::roundUp($model->payment_sum)))
            ->setCellValue('F19', Yii::$app->formatter->asInteger($summ->nds_sum))
            ->setCellValue('F20', Yii::$app->formatter->asInteger($summ->nds_sum))
            ->setCellValue('G19', Yii::$app->formatter->asInteger($total_summ))
            ->setCellValue('G20', Yii::$app->formatter->asInteger($total_summ));
        header('Content-Type: text/html');
        $contentDisposition = 'attachment';
        $fileName = 'invoice_'.$model->id.'.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($tmpl, 'Excel2007');
        header("Content-Disposition: {$contentDisposition};filename='".$fileName."'");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        Yii::$app->end();
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $contract_id
     * @return mixed
     */
    public function actionUpdate($id, $contract_id)
    {
        $model = $this->findModel($id, $contract_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'contract_id' => $model->contract_id]);
        } else {
            return $this->render('update',
                    [
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
    public function actionDelete($id, $contract_id)
    {
        $model = $this->findModel($id, $contract_id);
        if ($model->delete()) {
            if (!Yii::$app->request->isAjax) return $this->redirect(['index']);
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $contract_id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $contract_id)
    {
        if (($model = Payment::findOne(['id' => $id, 'contract_id' => $contract_id]))
            !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}