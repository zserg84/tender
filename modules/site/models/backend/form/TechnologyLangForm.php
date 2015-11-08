<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 15:28
 */

namespace modules\site\models\backend\form;


use modules\site\models\TechnologyLang;

class TechnologyLangForm extends TechnologyLang
{

    public function rules(){
        return [
            [['title', 'text', 'lang_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'title' => 'Название',
                'text' => 'Текст',
                'lang_id' => 'Язык',
            ]
        );
    }
} 