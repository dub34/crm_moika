<?php

namespace app\modules\ticket\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ticket\models\Ticket;

/**
 * SearchTicket represents the model behind the search form about `app\modules\ticket\models\Ticket`.
 */
class SearchTicket extends Ticket
{

    public $actDate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contract_id', 'priznak'], 'integer'],
            [['created_at', 'closed_at', 'pometka', 'to_date', 'closed_to_date', 'actDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Ticket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['print']) ? null : Yii::$app->settings->get('ticket.GridDefaultSize'),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
        ]);

        //if contract_id present in url, set it to the model
        if (is_array($params) && isset($params['id'])) {
            $params['SearchTicket']['contract_id'] = $params['id'];
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

//        if (null !== $this->created_at || null !== $this->to_date) {
        if ($this->created_at !== null && strlen($this->created_at) > 0) {
            $this->to_date == null ? $this->to_date = $this->created_at : null;
            $query->andWhere(['between', 'created_at', Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d 00:00'), Yii::$app->formatter->asDate($this->to_date, 'php:Y-m-d 23:59')]);
        }

        if ($this->closed_at !== null && strlen($this->closed_at) > 0) {
            $this->closed_to_date == null ? $this->closed_to_date = $this->closed_at : null;
            $query->andWhere(['between', 'closed_at', Yii::$app->formatter->asDate($this->closed_at, 'php:Y-m-d 00:00'), Yii::$app->formatter->asDate($this->closed_to_date, 'php:Y-m-d 23:59')]);
            $query->andWhere('closed_at IS NOT NULL');
        }

        if ($this->closed_at == '1') {
            $query->andWhere('closed_at IS NOT NULL');
        } elseif ($this->closed_at == '0') {
            $query->andWhere('closed_at IS NULL');
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'contract_id' => $this->contract_id,
        ]);

        return $dataProvider;
    }

    public function searchTicketsForReport()
    {
        $query = Ticket::find();


        if ($this->created_at !== null && strlen($this->created_at) > 0) {
            $this->to_date == null ? $this->to_date = $this->created_at : null;
            $query->andWhere(['between', 'created_at', Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d 00:00'), Yii::$app->formatter->asDate($this->to_date, 'php:Y-m-d 23:59')]);
        }

        if ($this->closed_at !== null && strlen($this->closed_at) > 0) {
            $this->closed_to_date == null ? $this->closed_to_date = $this->closed_at : null;
            $query->andWhere(['between', 'closed_at', Yii::$app->formatter->asDate($this->closed_at, 'php:Y-m-d 00:00'), Yii::$app->formatter->asDate($this->closed_to_date, 'php:Y-m-d 23:59')]);
            $query->andWhere('closed_at IS NOT NULL');
        }

        if ($this->closed_at == '1') {
            $query->andWhere('closed_at IS NOT NULL');
        } elseif ($this->closed_at == '0') {
            $query->andWhere('closed_at IS NULL');
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'contract_id' => $this->contract_id,
        ]);

        return $query->all();
    }

}
