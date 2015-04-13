<?php

namespace app\modules\employee\models;

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
 * @property integer $position_id
 */

class EmployeeHasPosition extends \yii\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'employee_has_position';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['office_id','employee_id','position_id'], 'integer'],
		];
	}


	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPosition()
	{
		return $this->hasOne(Position::className(), ['id'=>'position_id']);
	}

}
