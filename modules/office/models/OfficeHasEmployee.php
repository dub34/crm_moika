<?php

namespace app\modules\office\models;

use Yii;
use app\modules\employee\models\Employee;
use yii\base\ErrorException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "office".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $employee_id
 */
class OfficeHasEmployee extends \yii\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'office_has_employee';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['office_id','employee_id'], 'integer'],
		];
	}


	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getEmployee()
	{
		return $this->hasOne(Employee::className(), ['employee_id' => 'id']);
	}

}
