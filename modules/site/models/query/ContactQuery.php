<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\Contact]].
 *
 * @see \modules\site\models\Contact
 */
class ContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\Contact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\Contact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}