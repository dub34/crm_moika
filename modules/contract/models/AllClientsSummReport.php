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
class AllClientsSummReport extends ReportModel
{
    public function getData()
    {
        return Yii::$app->db->createCommand('CALL `allClientsTicketClose`(:start_date,:stop_date)',[':start_date'=>Yii::$app->formatter->asDate($this->date_start,'php:Y-m-d'),':stop_date'=>Yii::$app->formatter->asDate($this->date_stop,'php:Y-m-d')])->queryAll();
    }
    
}
