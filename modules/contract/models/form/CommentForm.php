<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.04.15
 * Time: 15:19
 */

namespace modules\contract\models\form;

use modules\themes\Module as ThemeModule;

class CommentForm extends \yii\base\Model
{

    public $text;

//    public $captcha;

    public $estimate;

    public $self_contract_id;

    public function rules(){
        return [
            [['text',/* 'captcha',*/ 'self_contract_id'], 'required'],
            [['text'], 'string'],
            [['estimate'], 'number'],
//            ['captcha', 'captcha', 'captchaAction'=>'/site/default/captcha'],
        ];
    }

    public function scenarios()
    {
        return [
            'ajax' => [
                'text', 'self_contract_id', 'estimate', /*'captcha',*/
            ],
            'default' => [
                'text', 'self_contract_id', 'estimate', /*'captcha',*/
            ]
        ];
    }

    public function attributeLabels(){
        return [
            'add_comment' => ThemeModule::t('ALL_INTERFACES', 'COMMENT_ADD'),
            'comment_positive' => ThemeModule::t('ALL_INTERFACES', 'COMMENT_POSITIVE'),
            'comment_neutral' => ThemeModule::t('ALL_INTERFACES', 'COMMENT_NEUTRAL'),
            'comment_negative' => ThemeModule::t('ALL_INTERFACES', 'COMMENT_NEGATIVE'),
        ];
    }
} 