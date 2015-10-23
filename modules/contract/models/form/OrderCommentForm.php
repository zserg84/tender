<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 06.05.15
 * Time: 11:51
 */

namespace modules\contract\models\form;


use yii\base\Model;
use modules\themes\Module as ThemeModule;

class OrderCommentForm extends Model
{
    public $text;

    public $order_id;

    public function rules(){
        return [
            [['text', 'order_id'], 'required'],
            [['text'], 'string'],
        ];
    }

    public function scenarios()
    {
        return [
            'ajax' => [
                'text', 'order_id',
            ],
            'default' => [
                'text', 'order_id',
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