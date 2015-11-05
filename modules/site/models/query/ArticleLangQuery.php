<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\ArticleLang]].
 *
 * @see \modules\site\models\ArticleLang
 */
class ArticleLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\ArticleLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\ArticleLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}