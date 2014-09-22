<?php

namespace app\modules\client\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $name
 * @property string $register_address
 * @property string $post_address
 * @property string $chief_name
 * @property string $chief_post
 * @property string $bank_name
 * @property integer $bank_code
 * @property integer $payment_account
 * @property integer $unp
 * @property integer $okpo
 * @property integer $fax
 * @property integer $telephone
 * @property string $email
 * @property string $responsible_person
 *
 * @property Contract[] $contracts
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','register_address', 'post_address', 'chief_name', 'bank_name','bank_code', 'payment_account', 'unp', 'okpo', 'fax', 'telephone'], 'required'],
            [['register_address', 'post_address', 'chief_name', 'chief_post', 'bank_name', 'responsible_person'], 'string'],
            [['bank_code', 'payment_account', 'unp', 'okpo'], 'integer'],
            ['email','email'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'register_address' => 'Юрид. Адрес',
            'post_address' => 'Почт. адрес',
            'chief_name' => 'Руководитель',
            'chief_post' => 'Должность',
            'bank_name' => 'Банк',
            'bank_code' => 'Код банка',
            'payment_account' => 'Расчетный счет',
            'unp' => 'УНП',
            'okpo' => 'ОКПО',
            'fax' => 'Факс',
            'telephone' => 'Телефон',
            'email' => 'E-mail',
            'responsible_person' => 'Отв. лицо',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['client_id' => 'id']);
    }
}
