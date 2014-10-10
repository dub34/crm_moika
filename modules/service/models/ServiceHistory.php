<?php

namespace app\modules\service\models;

use Yii;

/**
 * This is the model class for table "service_history".
 *
 * @property integer $id
 * @property integer $service_history_id
 * @property string $name
 * @property string $description
 * @property string $version
 *
 * @property Service $service
 * @property TicketHasService[] $ticketHasServices
 */
class ServiceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
        ];
    }

    public static function getActualVersionsByDate($date=null){
        if ($date !== null)
            $result = ServiceHistory::find()->where(['<=','date_format(version_created_at,\'%Y-%m-%d\')',Yii::$app->formatter->asDate($date,'php:Y-m-d')])->all();
        else $result = [];
            return $result;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['service_history_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHasServices()
    {
        return $this->hasMany(TicketHasService::className(), ['service_revision_id' => 'id']);
    }
}
