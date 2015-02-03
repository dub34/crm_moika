<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 2.2.15
 * Time: 17.53
 */

namespace app\modules\client\models;


use yii\db\ActiveQuery;

class ClientQuery extends ActiveQuery
{
    /**
     * @param bool $both if $both - $state ignored. Show all rows.
     * @param bool $state by default show only not deleted rows
     * @return $this
     */
    public function isDeleted($both = false, $state = false)
    {

        if (!$both) {
            $this->andWhere(['is_deleted' => $state]);
        }
        return $this;
    }
}