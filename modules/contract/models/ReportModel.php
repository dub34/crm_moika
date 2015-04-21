<?php

namespace app\modules\contract\models;

use Yii;
use app\modules\client\models\Client;
use app\modules\ticket\models\Ticket;
use yii\base\Model;

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
class ReportModel extends Model
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
}
