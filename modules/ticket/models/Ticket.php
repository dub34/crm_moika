<?php

namespace app\modules\ticket\models;

use Yii;
use app\modules\contract\models\Contract;
use app\modules\service\models\Service;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $contract_id
 * @property string $created_at
 * @property string $closed_at
 * @property integer $priznak
 * @property string $pometka
 *
 * @property int $ticket_count Set count for printing
 * 
 * @property Contract $contract
 * @property TicketHasService[] $ticketHasServices
 * @property Service[] $services
 */
class Ticket extends \yii\db\ActiveRecord
{
    public $ticket_count;
    public $to_date;
    public $services_list=[];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id'], 'required'],
            [['ticket_count'], 'required','on'=>'default'],
            [['closed_at','services_list'],'required','on'=>'update'],
            [['services_list'], 'safe','on'=>'update'],
            [['contract_id', 'priznak','ticket_count'], 'integer'],
            [['created_at', 'closed_at', 'to_date','services_list'], 'safe'],
            [['pometka'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ticket', 'ID'),
            'contract_id' => Yii::t('ticket', 'Contract ID'),
            'created_at' => Yii::t('ticket', 'Created At'),
            'closed_at' => Yii::t('ticket', 'Closed At'),
            'priznak' => Yii::t('ticket', 'Priznak'),
            'pometka' => Yii::t('ticket', 'Pometka'),
            'ticket_count' => Yii::t('ticket', 'Ticket count'),
            'office_id' => Yii::t('ticket', 'Office'),
            'services_list' => Yii::t('ticket', 'Services List'),
        ];
    }

    
    public function afterFind() {
        $this->services_list = $this->services;
        $this->created_at = $this->created_at?Yii::$app->formatter->asDate($this->created_at,'php:d.m.Y'):null;
        $this->closed_at = $this->closed_at!==null? Yii::$app->formatter->asDate($this->closed_at,'php:d.m.Y'):null;
        parent::afterFind();
    }

    public function beforeSave($insert) {
        $this->closed_at =  Yii::$app->formatter->asDate($this->closed_at,'php:Y-m-d H:i');
        $this->created_at =  Yii::$app->formatter->asDate($this->created_at,'php:Y-m-d H:i');
        
//        $this->rollBackBalance();
        
        //Delete all services from ticket before save new
        Yii::$app->db->createCommand()->delete('ticket_has_service','ticket_id=:ticket_id',[':ticket_id'=>$this->id])->execute();
        Yii::$app->db->createCommand('CALL calcBalance(:contract_id)',[':contract_id'=>$this->contract_id])->execute();
        
        return parent::beforeSave($insert);
    }
    
    public function beforeDelete() {
        Yii::$app->db->createCommand()->delete('ticket_has_service','ticket_id=:ticket_id',[':ticket_id'=>$this->id])->execute();
        return parent::beforeDelete();
    }
    
    public function afterDelete() {
        Yii::$app->db->createCommand('CALL calcBalance(:contract_id)',[':contract_id'=>$this->contract_id])->execute();
        return parent::afterDelete();
    }
    
    public function afterSave($insert, $changedAttributes) {
        //Create array for batchInsert services
        $tickets = [];
        $services = [];
        array_walk($this->services_list, function($el)use (&$tickets,&$services){
            $services[] = $service = Service::findOne($el)->getVersionByCreateDate($this->closed_at);
            $tickets[] = [$this->id,$el,$service['version']];
        });
        //Save services to tickets
        if (count($tickets)>0){
            Yii::$app->db->createCommand()->batchInsert('ticket_has_service', ['ticket_id','service_id','version_id'], $tickets)->execute();
        }
        Yii::$app->db->createCommand('CALL calcBalance(:contract_id)',[':contract_id'=>$this->contract_id])->execute();
        parent::afterSave($insert, $changedAttributes);
    }

    public function getSumm()
    {
        $services = \yii\helpers\ArrayHelper::getColumn($this->services, 'price');
        return is_numeric(array_sum($services))?array_sum($services):null;
    }
    
    public function getSummWithoutNDS()
    {
        
        return $this->summ !==null ? $this->summ-$this->summNDS:'';
    }
    
    public function getSummNDS()
    {
        return $this->summ!==null?($this->summ/100)*18:'';
    }
    
    public function getProgramms()
    {
        return $services =implode(',', \yii\helpers\ArrayHelper::getColumn($this->services, 'name'));
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHasServices()
    {
        return $this->hasMany(TicketHasService::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])->viaTable('ticket_has_service', ['ticket_id' => 'id']);
//                ->join('LEFT JOIN','service_history sh',['service.id'=>'sh.id','service.version'=>'sh.version']);
    }
}