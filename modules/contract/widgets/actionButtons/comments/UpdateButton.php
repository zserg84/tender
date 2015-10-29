<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.10.15
 * Time: 15:08
 */

namespace modules\contract\widgets\actionButtons\comments;

use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use modules\contract\Module as ContractModule;

class UpdateButton extends Button
{
    public function init()
    {
        $this->button = Html::a(ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_EDIT_LINK'), "javascript:void(0)", [
            'class' => 'comment_update_link'
        ]);

        parent::init();
    }
} 