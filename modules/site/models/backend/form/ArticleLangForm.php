<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 12:07
 */

namespace modules\site\models\backend\form;


use modules\site\models\ArticleLang;

class ArticleLangForm extends ArticleLang
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