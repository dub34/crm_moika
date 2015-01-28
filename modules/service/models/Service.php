<?php

namespace app\modules\service\models;

use Yii;
use app\components\behaviors\ModelVersioning;
/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property integer $service_history_id
 * @property string $name
 * @property string $description
 * @property string $version
 *
 * @property ServiceHistory $serviceHistory
 * @property TicketHasService $ticketHasService
 * @property Ticket[] $tickets
 */
class Service extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }
    
    public function behaviors() {
        $behaviors=[
            'ModelVersioning'=>[
                'class'=>  ModelVersioning::className(),
                'versionTable'=>'service_history',
                'createdAtField'=>'version_created_at',
                'createdByField'=>'version_created_by',
                'versionCommentField'=>'version_comment'
            ]
        ];
       return array_merge(parent::behaviors(),$behaviors);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
//            [['service_history_id'], 'integer'],
            [['name','price'], 'string'],
            [['version','description','nds'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'service_history_id' => 'Ревизия',
            'name' => Yii::t('service','Name'),
            'price' => Yii::t('service','Price'),
            'description' => Yii::t('service','Description'),
            'nds' => Yii::t('service','Nds'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceHistory()
    {

        
//        return $this->hasOne(ServiceHistory::className(), ['id' => 'service_history_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketHasService()
    {
        return $this->hasOne(TicketHasService::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['id' => 'ticket_id'])->viaTable('ticket_has_service', ['service_id' => 'id']);
    }
}
