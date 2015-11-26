<?php

namespace modules\site\models\query;

/**
 * This is the ActiveQuery class for [[\modules\site\models\ArticleImage]].
 *
 * @see \modules\site\models\ArticleImage
 */
class ArticleImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\ArticleImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\ArticleImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}