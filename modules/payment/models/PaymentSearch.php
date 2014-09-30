<?php

namespace app\modules\contract\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\payment\models\Payment;

/**
 * PaymentSearch represents the model behind the search form about `app\modules\payment\models\Payment`.
 */
class PaymentSearch extends Payment
{
    public function rules()
    {
        return [
            [['id', 'contract_id'], 'integer'],
            [['payment_sum', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payment_sum', $this->payment_sum]);

        return $dataProvider;
    }
}
