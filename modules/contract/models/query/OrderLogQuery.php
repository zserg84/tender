<?php

namespace modules\contract\models\query;

/**
 * This is the ActiveQuery class for [[\modules\contract\models\OrderLog]].
 *
 * @see \modules\contract\models\OrderLog
 */
class OrderLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\contract\models\OrderLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\contract\models\OrderLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}