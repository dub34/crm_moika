<?php

namespace app\modules\client\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\client\models\Client;

/**
 * ClientSearch represents the model behind the search form about `app\modules\client\models\Client`.
 */
class ClientSearch extends Client
{
    public function rules()
    {
        return [
            [['id', 'bank_code', 'payment_account', 'unp', 'okpo', 'fax', 'telephone'], 'integer'],
            [['name', 'register_address', 'post_address', 'chief_name', 'chief_post', 'bank_name', 'email', 'responsible_person'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->orderBy='name';

        $query->andFilterWhere([
            'id' => $this->id,
            'bank_code' => $this->bank_code,
            'payment_account' => $this->payment_account,
            'unp' => $this->unp,
            'okpo' => $this->okpo,
            'fax' => $this->fax,
            'telephone' => $this->telephone,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'register_address', $this->register_address])
            ->andFilterWhere(['like', 'post_address', $this->post_address])
            ->andFilterWhere(['like', 'chief_name', $this->chief_name])
            ->andFilterWhere(['like', 'chief_post', $this->chief_post])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'responsible_person', $this->responsible_person]);

        return $dataProvider;
    }
}
