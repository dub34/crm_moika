<?php

namespace app\modules\contract\models;

use Yii;
use yii\data\ActiveDataProvider;

class SaldoReportModel extends ReportModel
{

	public function getData()
	{
		$query = Contract::find();
		$query->where(['is_active'=>true]);
		$query->joinWith([
			'client' => function ($q) {
				$q->isDeleted();
			}
		]);
		$query->andwhere(['>','contract.balance','0']);



		return $query->all();
	}
}
