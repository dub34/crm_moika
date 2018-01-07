<?php

namespace app\modules\contract\models;

use app\modules\ticket\models\SearchTicket;
use Yii;
use app\modules\client\models\Client;
use app\modules\ticket\models\Ticket;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CalculationModel extends Model
{

    public $closed_at;
    public $closed_to_date;
    public $contract_id;
    public $serviceSumm;
    public $serviceSummNDS;
    public $serviceSummWithoutNDS;
    public $post;
    public $actDate;

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['date_start','date_stop'], 'safe'],
//            [['date_start','date_stop'], 'required'],
//        ];
//    }

    /**
     * @inheritdoc
     */
//    public function attributeLabels()
//    {
//        return [
//            'date_start' => Yii::t('contract', 'Date start'),
//            'date_stop' => Yii::t('contract', 'Date stop'),
//            'closed_at'=>Yii::t('ticket', 'Closed At'),
//            'summ'=>Yii::t('contract', 'Summ')
//        ];
//    }

    /**
     *
     */
    public function __construct($config)
    {
        if (!isset($config['contract_id'])) {
            throw new InvalidConfigException();
        }
        $this->contract_id = $config['contract_id'];
        $this->closed_at = $config['closed_at'];
        $this->closed_to_date = $config['closed_to_date'];
        $this->actDate = $config['actDate'];
//		$this->post = $config['post'];
        parent::__construct($config);
    }

    public function init()
    {
        $this->getServicesSumm();
    }

    public function getStartSaldo()
    {
        return Ticket::getStartBalance($this->contract_id,
            $this->closed_at);
    }

    /**
     * @return array
     */
    public function getTickets()
    {
        $tickets = new SearchTicket();
        $tickets->contract_id = $this->contract_id;
//		$tickets->to_date = $this->closed_at;
        $tickets->closed_at = $this->closed_at;
        $tickets->closed_to_date = $this->closed_to_date;

        return $tickets->searchTicketsForReport();
    }

    public function getActNumber()
    {
        $current = \Yii::$app->settings->get('main.currentActNumber');
        \Yii::$app->settings->set('main.currentActNumber', $current + 1);
        return $current;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getPayments()
    {
        return Ticket::getPaymentsForAct($this->closed_at, $this->closed_to_date,
            $this->contract_id);
    }

    public function getPaymentsSumm()
    {
        return \app\modules\ticket\models\Ticket::getPaymentSumm($this->getPayments());
    }


    public function getServicesSumm()
    {
        $summ = [
            'summ' => [],
            'summ_nds' => [],
            'summ_without_nds' => [],
        ];

        foreach ($this->getTickets() as $ticket) {
            $services = $ticket->services;
            $summ['summ'] = array_merge($summ['summ'], ArrayHelper::getColumn($services, 'sum_price'));
            $summ['summ_nds'] = array_merge($summ['summ_nds'], ArrayHelper::getColumn($services, 'priceNDS'));
            $summ['summ_without_nds'] = array_merge($summ['summ_without_nds'],
                ArrayHelper::getColumn($services, 'priceWithoutNDS'));
        }

        $summ = array_map('array_sum', $summ);
        $this->serviceSumm = $summ['summ'];
        $this->serviceSummNDS = $summ['summ_nds'];
        $this->serviceSummWithoutNDS = $summ['summ_without_nds'];
    }

    public function getEndSaldo()
    {
        return $this->startSaldo - $this->serviceSumm + $this->paymentsSumm;
    }

}
