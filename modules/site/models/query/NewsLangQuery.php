<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\NewsLang]].
 *
 * @see \modules\site\models\NewsLang
 */
class NewsLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\NewsLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\NewsLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}