<?php

namespace app\modules\payment\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $contract_id
 * @property string $payment_sum
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Contract $contract
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id'], 'required'],
            [['contract_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['payment_sum'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('payment', 'ID'),
            'contract_id' => Yii::t('payment', 'Contract ID'),
            'payment_sum' => Yii::t('payment', 'Payment Sum'),
            'created_at' => Yii::t('payment', 'Created At'),
            'updated_at' => Yii::t('payment', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
}
