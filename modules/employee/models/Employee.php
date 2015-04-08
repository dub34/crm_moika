<?php

namespace app\modules\employee\models;

use Yii;
use app\modules\office\models\Office;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $name
 * @property string $sign_img
 * @property string $login
 *
 * @property Contract[] $contracts
 * @property Office $office
 */
class Employee extends \yii\db\ActiveRecord
{
    public $position_id;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['office_id'], 'required'],
            [['office_id'], 'integer'],
            [['name', 'login'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'office_id' => 'Филиал',
            'name' => 'ФИО сотрудника',
            'login' => 'Логин',
            'sign_img' => 'образец подписи',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

	public function getPosition(){
		return $this->hasOne(EmployeeHasPosition::className(),['employee_id'=>'id'])->where(['office_id'=>$this->office_id]);
	}
}
