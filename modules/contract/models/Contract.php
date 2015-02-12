<?php

namespace app\modules\contract\models;

use app\modules\employee\models\Employee;
use Yii;
use app\modules\client\models\Client;
use app\modules\ticket\models\Ticket;
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
    public $tstCreatedAt;
    
    public $visibleDateFormat = 'd.m.Y';
    public $storeDateFormat = 'Y-m-d H:i:s';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract';
    }


    public function scenarios()
    {
        return [
            'create' => ['client_id', 'employee_id', 'created_at', 'number'],
            'default' => ['client_id', 'employee_id', 'created_at', 'number']
        ];
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'employee_id'], 'integer'],
            [['created_at'], 'required'],
            [['created_at'], 'date','format'=> 'd.m.yyyy','timestampAttribute'=>'tstCreatedAt'],
            [['number', 'employee_id'], 'safe'],
            [['number'], 'unique', 'filter' => ['!=', 'number', $this->oldAttributes['number']], 'on' => 'default'],
            [['number'], 'unique', 'on' => 'create'],
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
            'client' => Yii::t('contract', 'Client'),
            'employee_id' => Yii::t('contract', 'Employee ID'),
            'number' => Yii::t('contract', 'Number'),
            'created_at' => Yii::t('contract', 'Created At'),
            'balance' => Yii::t('contract', 'Balance'),
        ];
    }

    public function beforeSave($insert) {
        $this->created_at = date($this->storeDateFormat,$this->tstCreatedAt);
        ($this->number == null)?$this->getContractNumber():null;
        return parent::beforeSave($insert);
    }
    
    public function afterFind() {
        $this->created_at = date_format(date_create_from_format($this->storeDateFormat, $this->created_at), $this->visibleDateFormat);
        return parent::afterFind();
    }

    //Get number for new contract
    protected function getContractNumber()
    {
        $number = Yii::$app->db->createCommand('SELECT MAX(CAST(number as UNSIGNED))+1 FROM contract')->queryScalar();
        $this->number = $number;
    }
            
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id'])->isDeleted();
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
