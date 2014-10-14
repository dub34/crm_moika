<?php

namespace app\modules\service\models;

use Yii;
/**
 * This is the model class for view "actualServiceVersions".
 *
 * @property integer $id
 * @property integer $service_history_id
 * @property string $name
 * @property string $description
 * @property string $version
 * @property int $contract_id
 * @property int $ticket_id
 *
 */
class ActualService extends \yii\db\ActiveRecord
{
    public $summBezNDS=[];




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actualServiceVersions';
    }
    
    public function behaviors() {
        $behaviors=[
//            'ModelVersioning'=>[
//                'class'=>  ModelVersioning::className(),
//                'versionTable'=>'service_history',
//                'createdAtField'=>'version_created_at',
//                'createdByField'=>'version_created_by',
//                'versionCommentField'=>'version_comment'
//            ]
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
            [['version','description'],'safe']
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
    
    
     public function getPriceNDS()
    {
        return ($this->price!==null && $this->price!==0) ?($this->price/100)*$this->nds:'';
    }
    
    public function getPriceWithoutNDS()
    {
        $val = $this->price !==null ? $this->price-$this->priceNDS:'';
        return $val;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getServiceHistory()
//    {
//
//        
////        return $this->hasOne(ServiceHistory::className(), ['id' => 'service_history_id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getTicketHasService()
//    {
//        return $this->hasOne(TicketHasService::className(), ['service_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getTickets()
//    {
//        return $this->hasMany(Ticket::className(), ['id' => 'ticket_id'])->viaTable('ticket_has_service', ['service_id' => 'id']);
//    }
}
