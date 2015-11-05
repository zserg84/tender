<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 11:26
 */

namespace modules\site\models\backend\form;

use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\site\models\News;

class NewsForm extends News
{

    public $translationTitle = [];
    public $translationText = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['translationTitle', 'translationText'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['translationTitle', 'translationText'], LangRequiredValidator::className(), 'langUrls' => 'ru', 'currentLangRequired' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'translationTitle' => 'Название',
                'translationText' => 'Текст',
            ]
        );
    }
} 