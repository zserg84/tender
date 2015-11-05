<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:20
 */

namespace modules\site\models\backend\form;


use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\site\models\Technology;

class TechnologyForm extends Technology
{

    public $translationTitle = [];
    public $translationText = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id'], 'safe'],
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