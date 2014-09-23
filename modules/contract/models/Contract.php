<?php

namespace app\modules\contract\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $employee_id
 * @property string $number
 * @property string $created_at
 *
 * @property Client $client
 * @property Employee $employee
 * @property Ticket $ticket
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'employee_id'], 'required'],
            [['client_id', 'employee_id'], 'integer'],
            [['created_at'], 'safe'],
            [['number'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('contract', 'ID'),
            'client_id' => Yii::t('contract', 'Client ID'),
            'employee_id' => Yii::t('contract', 'Employee ID'),
            'number' => Yii::t('contract', 'Number'),
            'created_at' => Yii::t('contract', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['contract_id' => 'id']);
    }
}
