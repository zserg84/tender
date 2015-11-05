<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\Partner]].
 *
 * @see \modules\site\models\Partner
 */
class PartnerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\Partner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\Partner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}