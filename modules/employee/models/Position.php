<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 02.04.15
 * Time: 17:41
 */

namespace app\modules\employee\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Position extends ActiveRecord{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'position';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Должность',
		];
	}

	public function search($params)
	{
		$query = self::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

//		$query->andFilterWhere([
//			'id' => $this->id,
//			'user_id' => $this->office_id,
//		]);

		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
} 