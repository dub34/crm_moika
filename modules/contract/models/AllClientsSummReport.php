<?php

namespace app\modules\contract\models;

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
class AllClientsSummReport extends \yii\db\ActiveRecord
{
 
    public $date_start;
    public $date_stop;
    
//    /**
//     * @inheritdoc
//     */
//    public static function tableName()
//    {
//        return 'contract';
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_start','date_stop'], 'safe'],
            [['date_start','date_stop'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date_start' => Yii::t('contract', 'Date start'),
            'date_stop' => Yii::t('contract', 'Date stop'),
            'closed_at'=>Yii::t('ticket', 'Closed At'),
            'summ'=>Yii::t('contract', 'Summ')
        ];
    }
    
    public function getData()
    {
        return Yii::$app->db->createCommand('CALL `crm_moika`.`allClientsTicketClose`(:start_date,:stop_date)',[':start_date'=>Yii::$app->formatter->asDate($this->date_start,'php:Y-m-d'),':stop_date'=>Yii::$app->formatter->asDate($this->date_stop,'php:Y-m-d')])->queryAll();
    }
    
}
