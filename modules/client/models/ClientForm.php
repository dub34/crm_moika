<?php

namespace app\modules\client\models;

use Yii;

/**
 * This is the model class for table "client_form".
 *
 * @property integer $id
 * @property string $short_name
 * @property string $full_name
 *
 */
class ClientForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_name'], 'required'],
            [['short_name','full_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_name' => 'Краткое название',
            'full_name' => 'Полное название',
            
        ];
    }
}
