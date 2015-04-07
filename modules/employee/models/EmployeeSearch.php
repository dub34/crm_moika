<?php

namespace app\modules\employee\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\employee\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form about `app\modules\employee\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public function rules()
    {
        return [
            [['id', 'office_id'], 'integer'],
            [['name', 'sign_img'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Employee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate()) && !$this->office_id) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'office_id' => $this->office_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sign_img', $this->sign_img]);

        return $dataProvider;
    }
}
