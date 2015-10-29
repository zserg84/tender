<?php

namespace modules\contract\models\query;

/**
 * This is the ActiveQuery class for [[\modules\contract\models\ContractOrder]].
 *
 * @see \modules\contract\models\ContractOrder
 */
class ContractOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\contract\models\ContractOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\contract\models\ContractOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}