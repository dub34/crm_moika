<?php

namespace app\modules\employee\models;

use app\modules\office\models\OfficeHasEmployee;
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
            [['id'], 'integer'],
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
        $query = Employee::find()->leftJoin('office_has_employee oe','employee.id=oe.employee_id');

        $query->andFilterWhere([
            'oe.office_id' => $this->office_id,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'oe.office_id' => $this->office_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sign_img', $this->sign_img]);

        return $dataProvider;
    }
}
