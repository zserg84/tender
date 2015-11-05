<?php

namespace modules\site\models\query;
use modules\lang\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\site\models\Technology]].
 *
 * @see \modules\site\models\Technology
 */
class TechnologyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\site\models\Technology[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\Technology|array|null
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
            'technologyLangs' => function($query) use($langId){
                $query->andOnCondition([
                    'technology_lang.lang_id' => $langId,
                ]);
            }
        ]);

        return $this;
    }
}