<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 22:07
 */

namespace modules\site\models\backend\form;


use modules\site\models\NewsLang;

class NewsLangForm extends NewsLang
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