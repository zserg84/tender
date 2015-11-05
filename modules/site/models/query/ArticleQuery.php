<?php

namespace modules\site\models\query;
use modules\lang\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\site\models\Article]].
 *
 * @see \modules\site\models\Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function lang($langId = null){
        if(!$langId){
            $lang = Lang::getCurrent();
            $langId = $lang->id;
        }

        $this->innerJoinWith([
            'articleLangs' => function($query) use($langId){
                $query->andOnCondition([
                    'article_lang.lang_id' => $langId,
                ]);
            }
        ]);

        return $this;
    }
}