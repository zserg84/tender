<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\TechnologyImage]].
 *
 * @see \modules\site\models\TechnologyImage
 */
class TechnologyImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\TechnologyImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\TechnologyImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}