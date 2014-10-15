<?php

namespace app\modules\office\models;

use Yii;
use app\modules\employee\models\Employee;

/**
 * This is the model class for table "office".
 *
 * @property integer $id
 * @property string $name
 * @property string $register_address 
 * @property integer $chief_name 
 * @property integer $glbuh_name 
 * @property integer $check_buh_name 
 * @property string $bank_name 
 * @property integer $bank_code 
 * @property integer $payment_account 
 * @property integer $unp 
 * @property integer $okpo 
 * @property string $telephone 
 * @property string $fax 
 * @property string $email 
 * @property Employee $employee
 */
class Office extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'office';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['register_address', 'bank_name', 'telephone', 'fax'], 'string'],
            [['chief_name', 'glbuh_name', 'check_buh_name', 'bank_code', 'payment_account', 'unp', 'okpo'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('office', 'ID'),
           'name' => Yii::t('office', 'Name'),
           'register_address' => Yii::t('office', 'Register Address'),
           'chief_name' => Yii::t('office', 'Chief Name'),
           'glbuh_name' => Yii::t('office', 'Glbuh Name'),
           'check_buh_name' => Yii::t('office', 'Check Buh Name'),
           'bank_name' => Yii::t('office', 'Bank Name'),
           'bank_code' => Yii::t('office', 'Bank Code'),
           'payment_account' => Yii::t('office', 'Payment Account'),
           'unp' => Yii::t('office', 'Unp'),
           'okpo' => Yii::t('office', 'Okpo'),
           'telephone' => Yii::t('office', 'Telephone'),
           'fax' => Yii::t('office', 'Fax'),
           'email' => Yii::t('office', 'Email'),
        ];
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee() {
        return $this->hasOne(Employee::className(), ['office_id' => 'id']);
    }
    public function getChief() {
        return $this->hasOne(Employee::className(), ['id' => 'chief_name']);
    }
    public function getGlbuh() {
        return $this->hasOne(Employee::className(), ['id' => 'glbuh_name']);
    }
    
    public function getCheckbuh() {
        return $this->hasOne(Employee::className(), ['id' => 'check_buh_name']);
    }
    
    public function getDefaultOffice()
    {
        return $this->findOne([Yii::$app->settings->get('office.defaultOffice')]);
    }
    
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['office_id' => 'id']);
    }

}
