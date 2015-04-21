<?php

namespace app\modules\contract\controllers;

use app\modules\contract\models\SaldoReportModel;
use Yii;
use app\components\controllers\Controller;
use yii\data\ArrayDataProvider;

/**
 * ContractController implements the CRUD actions for Contract model.
 */
class ReportsController extends Controller {

    public function behaviors() {
        $behaviors = [];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all Contract models.
     * @return mixed
     */
    public function actionIndex() {
        $chart_data = new \app\modules\contract\models\AllClientsSummReport();
        if ($chart_data->load(Yii::$app->request->post()) && $chart_data->validate()) {
            $data = $chart_data->getData();
        } else {
            $data = [];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $data]);
        return $this->render('index', [
                    'chart_data' => json_encode($data),
                    'model' => $chart_data,
                    'dataProvider' => $dataProvider,
        ]);
    }


	public function actionSaldo(){
		$saldoModel =new SaldoReportModel();

		if ($saldoModel->load(\Yii::$app->request->get())){
			$dataProvider = $saldoModel->getData();
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
			echo $this->render('_saldo_report',['saldoModel'=>$saldoModel,'contracts'=>$dataProvider]);
			$html = ob_get_contents();
			ob_end_clean();
			$pdf->WriteHTML($html);
			$filename = 'report-' . $saldoModel->date_start . '-' . $saldoModel->date_stop . '.pdf';
			$pdf->Output($filename, 'I');
			Yii::$app->end();
		};
		return $this->render('saldo',['saldoModel'=>$saldoModel]);
	}
}
