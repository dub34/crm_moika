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
//		$query->joinWith([
//			'client' => function ($q) {
////				$q->isDeleted();
//			}
//		]);
		$query->join('LEFT JOIN', 'actualServiceVersions s', 'contract.id=s.contract_id');

		$query->andwhere([
			'between',
			'date_format(s.closed_at,\'%Y-%m-%d\')',
			Yii::$app->formatter->asDate($this->date_start, 'php:Y-m-d'),
			Yii::$app->formatter->asDate($this->date_stop, 'php:Y-m-d')
		]);
		$query->addOrderBy('contract.created_at');

		return $query->all();
	}
}
