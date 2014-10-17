<?php

namespace app\modules\contract\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\contract\models\Contract;

/**
 * SearchContract represents the model behind the search form about `app\modules\contract\models\Contract`.
 */
class SearchContract extends Contract
{
    public $client;


    public function rules()
    {
        return [
            [['id', 'client_id', 'employee_id'], 'integer'],
            [['number', 'created_at','client'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Contract::find();
//        $query->joinWith(['client']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder' => [
                    'client_id'=>SORT_ASC,
                    'number' => SORT_ASC,
                ]
            ]
        ]);
//        $dataProvider->sort->attributes['client'] = [
//            'asc' => ['client.name' => SORT_ASC],
//            'desc' => ['client.name' => SORT_DESC],
//        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'number'=>$this->number,
            'client_id' => $this->client_id,
            'employee_id' => $this->employee_id,
            'created_at' => $this->created_at,
        ]);

//        $query->andFilterWhere(['like', 'number', $this->number])->
//                andFilterWhere(['like', 'client.name', $this->client]);
        return $dataProvider;
    }
}
