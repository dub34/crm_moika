<?php

namespace app\modules\service\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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
class ActualService extends Model
{
    public $summBezNDS = [];

    public $count;
    public $id;
    public $version;
    public $price;
    public $sum_price;
    public $name;
    public $version_created_by;
    public $version_created_at;
    public $version_comment;
    public $description;
    public $nds;
    public $contract_id;
    public $ticket_id;
    public $closed_at;


    /**
     * @inheritdoc
     */
//    public static function tableName()
//    {
//        return 'actualServiceVersions';
//    }

//    public function behaviors()
//    {
//        $behaviors = [
////            'ModelVersioning'=>[
////                'class'=>  ModelVersioning::className(),
////                'versionTable'=>'service_history',
////                'createdAtField'=>'version_created_at',
////                'createdByField'=>'version_created_by',
////                'versionCommentField'=>'version_comment'
////            ]
//        ];
//        return array_merge(parent::behaviors(), $behaviors);
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
//            [['service_history_id'], 'integer'],
            [['name', 'price'], 'string'],
            [['version', 'description'], 'safe']
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
            'name' => Yii::t('service', 'Name'),
            'price' => Yii::t('service', 'Price'),
            'description' => Yii::t('service', 'Description'),
            'nds' => Yii::t('service', 'Nds'),
        ];
    }


    public function getPriceNDS()
    {
        if ($this->sum_price !== null && $this->sum_price !== 0) {
            $percent = 100 + $this->nds;
            $summ = ($this->nds / $percent) * $this->sum_price;
            return \app\components\helpers\Helpers::roundUp($summ);
        }
        return '';
    }

    public function getPriceWithoutNDS()
    {
        $val = $this->sum_price !== null ? $this->sum_price - $this->priceNDS : '';
        return \app\components\helpers\Helpers::roundUp($val);
    }

    public static function getTicketSumPrice($ticket_id)
    {
        $services = \Yii::$app->db->createCommand('CALL actual_ticket_services(:ticket_id)', [':ticket_id' => $ticket_id])->queryAll();
        return array_sum(ArrayHelper::getColumn($services, 'sum_price', false));
//        return self::find()->select(['coalesce(SUM(sum_price),0) sum_price'])->where(['ticket_id'=>$ticket_id])->scalar();
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
