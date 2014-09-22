<?php

namespace app\modules\office\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\office\models\Office;

/**
 * OfficeSearch represents the model behind the search form about `app\modules\office\models\Office`.
 */
class OfficeSearch extends Office
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Office::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
