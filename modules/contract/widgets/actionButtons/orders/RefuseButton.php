<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.10.15
 * Time: 19:03
 */

namespace modules\contract\widgets\actionButtons\orders;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

class RefuseButton extends Button
{

    public function init()
    {
        $this->button = Html::a(ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_3_4_REFUSE_BUTTON'), Url::toRoute(['refuse', 'orderId'=>$this->model->id]), [
            'data-confirm' => ContractModule::t('PERFORMER_INTERFACE', 'SERVICE_MESSAGE_CONFIRM_DEL_OF_A_RESPONSE'),
//            'class' => 'response_delete_link',
        ]);

        parent::init();
    }

} 