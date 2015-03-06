<?php

namespace app\modules\ticket\models;

use app\components\helpers\Helpers;
use app\modules\contract\models\Contract;
use app\modules\office\models\Office;
use app\modules\service\models\ActualService;
use app\modules\service\models\Service;
use Yii;
use yii\helpers\ArrayHelper;

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
    public $closed_to_date;
    public $services_list = [];


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
            [['ticket_count'], 'required', 'on' => 'default'],
            [['closed_at', 'services_list'], 'required', 'on' => 'close_ticket'],
            [['services_list', 'office_id'], 'safe', 'on' => 'close_ticket'],
            [['contract_id', 'priznak', 'ticket_count'], 'integer'],
            [['created_at', 'closed_at', 'to_date', 'closed_to_date', 'services_list'], 'safe'],
            [['created_at'], 'required', 'on' => 'update'],
            [['pometka'], 'string', 'max' => 45],
            [['email'], 'email'],
            [['email'], 'validate_email_checked', 'on' => 'default'],
            [
                ['closed_at'],
                \nepstor\validators\DateTimeCompareValidator::className(),
                'format' => 'd.m.Y',
                'compareAttribute' => 'created_at',
                'operator' => '>='
            ]
        ];
    }


    //Not working, because not usin validation on create tickets. TODO: Add model validation before saving batch tickets.
    public function validate_email_checked($attribute, $params)
    {

        if (Yii::$app->request->get('send_email', null) !== null) {
            if (!$this->email || $this->email == '') {
                $this->addError('email', Yii::t('tickets', 'Необходимо заполнить поле E-mail'));
            }
        }
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
            'email' => Yii::t('client', 'Email'),
        ];
    }


    public function afterFind()
    {
        $this->services_list = \yii\helpers\ArrayHelper::getColumn($this->services, 'id');
        $this->created_at = $this->created_at ? Yii::$app->formatter->asDate($this->created_at, 'php:d.m.Y') : null;
        $this->closed_at = $this->closed_at !== null ? Yii::$app->formatter->asDate($this->closed_at,
            'php:d.m.Y') : null;
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $this->closed_at = $this->closed_at !== '' ? Yii::$app->formatter->asDate($this->closed_at,
            'php:Y-m-d H:i') : null;
        $this->created_at = Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d H:i');
//        if ($this->scenario == 'close_ticket'){
        //Delete all services from ticket before save new
        Yii::$app->db->createCommand()->delete('ticket_has_service', 'ticket_id=:ticket_id',
            [':ticket_id' => $this->id])->execute();
        Yii::$app->db->createCommand('CALL updateBalance(:contract_id)',
            [':contract_id' => $this->contract_id])->execute();
//        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        Yii::$app->db->createCommand()->delete('ticket_has_service', 'ticket_id=:ticket_id',
            [':ticket_id' => $this->id])->execute();
        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        Yii::$app->db->createCommand('CALL updateBalance(:contract_id)',
            [':contract_id' => $this->contract_id])->execute();
        return parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->services_list) && count($this->services_list) > 0) {
            //Create array for batchInsert services
            $tickets = [];
            $services = [];
            array_walk($this->services_list, function ($serviceAmount, $serviceId) use (&$tickets, &$services) {
                $services[] = $service = Service::findOne($serviceId)->getVersionByCreateDate($this->closed_at);
                for ($i = 0; $i < $serviceAmount; $i++) {
                    $tickets[] = [$this->id, $serviceId, $service['version']];
                }
            });
            //Save services to tickets
            if (count($tickets) > 0) {
                Yii::$app->db->createCommand()->batchInsert('ticket_has_service',
                    ['ticket_id', 'service_id', 'version_id'], $tickets)->execute();
            }
            Yii::$app->db->createCommand('CALL updateBalance(:contract_id)',
                [':contract_id' => $this->contract_id])->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getSumm()
    {
        $services = \yii\helpers\ArrayHelper::getColumn($this->services, 'price');
        return is_numeric(array_sum($services)) ? Helpers::roundUp(array_sum($services)) : null;
    }

    public function getSummNDS()
    {
        return ($this->summ !== null && $this->summ !== 0) ? ($this->summ / 100) * $this->nds : '';
    }

    public function getSummWithoutNDS()
    {

        return $this->summ !== null ? $this->summ - Helpers::roundUp($this->summNDS) : '';
    }

    public function getNds()
    {
        return (is_array($this->services) && count($this->services) > 0) ? $this->services[0]->nds : '';
    }

    public function getProgramms()
    {
        return $services = implode(',', \yii\helpers\ArrayHelper::getColumn($this->services, 'name'));
    }


    public function getFormattedServices($formatType = 'short')
    {
        switch ($formatType) {
            case 'short':
                return implode(',', \yii\helpers\ArrayHelper::map($this->services, 'id', 'name'));
                break;
            case 'withprice':
                $f = [];
                foreach ($this->services as $service) {
                    $s = $service->name . '(';
                    $s .= ($service->count > 1) ? $service->count . 'x' . $service->price : $service->price;
                    $s .= ')';

                    $f[] = $s;
                }
                return implode(', ', $f);
                break;
        }
    }

    public static function getStartBalance($contract_id, $start_date)
    {
        $cmd = Yii::$app->db->createCommand("CALL `calculateBalanceValue`(:contract_id,:start_date,@balance);", [
            ':contract_id' => $contract_id,
            ':start_date' => Yii::$app->formatter->asDate($start_date, 'php:Y-m-d')
        ])->execute();
        $balance = Yii::$app->db->createCommand("select @balance;")->queryScalar();
        return Helpers::roundUp($balance);
    }

    public static function getPaymentsForAct($start_period, $end_period, $contract_id)
    {
        return \app\modules\payment\models\Payment::find()->where([
            'between',
            'date_format(created_at,\'%Y-%m-%d\')',
            Yii::$app->formatter->asDate($start_period, 'php:Y-m-d'),
            Yii::$app->formatter->asDate($end_period, 'php:Y-m-d')
        ])
            ->andWhere('contract_id=:contract_id', [':contract_id' => $contract_id])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->contract->client->email;
    }

    /**
     * @return string
     */
    public function setEmail($value)
    {
        return $this->email = $value;
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
        return $this->hasMany(ActualService::className(), ['ticket_id' => 'id']);
    }

    public function getServicesAsArray()
    {
        $relatedServices = $this->services;
        $relatedServicesArray = ArrayHelper::toArray($relatedServices, [
            ActualService::className() => ['count', 'price', 'name', 'id']
        ]);
        return ArrayHelper::index($relatedServicesArray, 'id');
    }
}