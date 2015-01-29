<?php

namespace app\modules\payment\models;

use app\modules\contract\models\Contract;
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
    const PAYMENT_ACTIVE = 1;
    const PAYMENT_NONACTIVE = 0;

    public $tstCreatedAt;
    public $visibleDateFormat = 'php:d.m.Y';
    public $storeDateFormat = 'php:Y-m-d H:i:s';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    public function scenarios()
    {
        return [
            'create' => ['contract_id', 'created_at', 'payment_sum','nds','update_at','status'],
            'default'=>['contract_id', 'created_at', 'payment_sum','nds','update_at','status']
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id', 'created_at', 'payment_sum'], 'required'],
            [['contract_id', 'status', 'nds'], 'integer'],
            [['nds'], 'default', 'value' => Yii::$app->settings->get('nds'), 'on' => 'create'],
            [['created_at', 'updated_at', 'status'], 'safe'],
            [['created_at'], 'date', 'format' => 'php:d.m.Y'],
            [['payment_sum'], 'string', 'max' => 25],
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
            'status' => Yii::t('payment', 'status'),
        ];
    }

    public function beforeSave($insert)
    {

        $this->created_at = Yii::$app->formatter->asDate($this->created_at,
            $this->storeDateFormat);
        $this->payment_sum = \app\components\helpers\Helpers::roundUp($this->payment_sum);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if (null !== $this->created_at)
                $this->created_at = Yii::$app->formatter->asDate($this->created_at,
                $this->visibleDateFormat);
        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }
}