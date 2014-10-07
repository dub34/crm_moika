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

    public function beforeSave($insert) {
        $this->closed_at =  Yii::$app->formatter->asDate($this->closed_at,'php:Y-m-d H:i');
           return parent::beforeSave($insert);
    }
    
    
    public function afterSave($insert, $changedAttributes) {
        $tickets = [];
        array_walk($this->services_list, function($el)use (&$tickets){
            $service = Service::findOne($el);
                    $v = $service->getVersionByCreateDate($this->closed_at);
            $tickets[] = [$this->id,$el];
        });
        if (count($tickets)>0){
            Yii::$app->db->createCommand()->batchInsert('ticket_has_service', ['ticket_id','service_id'], $tickets)->execute();
        }
        parent::afterSave($insert, $changedAttributes);
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
    }
}