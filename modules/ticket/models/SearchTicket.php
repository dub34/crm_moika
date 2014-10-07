<?php

namespace app\modules\ticket\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ticket\models\Ticket;

/**
 * SearchTicket represents the model behind the search form about `app\modules\ticket\models\Ticket`.
 */
class SearchTicket extends Ticket {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'contract_id', 'priznak'], 'integer'],
            [['created_at', 'closed_at', 'pometka', 'to_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Ticket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        //if contract_id present in url, set it to the model
        if ($params['id']) {
            $params['SearchTicket']['contract_id'] = $params['id'];
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

//        if (null !== $this->created_at || null !== $this->to_date) {
        if ($this->created_at !==null)
        {
            $this->to_date == null ?$this->to_date=$this->created_at:null;
            
            $query->andWhere(['between', 'created_at', Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d 00:00'), Yii::$app->formatter->asDate($this->to_date, 'php:Y-m-d 23:59')]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'contract_id' => $this->contract_id,
//            'created_at' => $this->created_at !==null ?Yii::$app->formatter->asDate($this->created_at, 'php:Y-m-d'):null,
            'closed_at' => $this->closed_at,
            'priznak' => $this->priznak,
        ]);

        $query->andFilterWhere(['like', 'pometka', $this->pometka]);

        return $dataProvider;
    }

}
