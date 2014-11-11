<?php

namespace app\modules\contract\controllers;

use Yii;
use app\components\controllers\Controller;

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

}
