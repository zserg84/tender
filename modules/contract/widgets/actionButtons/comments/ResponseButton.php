<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.10.15
 * Time: 15:10
 */

namespace modules\contract\widgets\actionButtons\comments;


use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use modules\contract\Module as ContractModule;

class ResponseButton extends Button
{

    public function init()
    {
        $this->button = Html::a(ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_RESPONSE_LINK'), "javascript:void(0)", [
            'class' => 'comment_response_link'
        ]);

        parent::init();
    }
} 