<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.11.15
 * Time: 16:09
 */

namespace modules\contract\widgets\actionButtons\orders;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

class OrderDoneButton extends Button
{

    public function init()
    {
        $this->title = $this->title ? $this->title : ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_DONE_BUTTON');

        $this->button = Html::a($this->title, Url::toRoute(['/contract/order/status-done']), [
            'class' => 'order_done',
            'data-confirm' => ContractModule::t('PERFORMER_INTERFACE', 'SERVICE_MESSAGE_CONFIRM_DONE_OF_A_RESPONSE'),
        ]);

        $this->jsHandler = '
                $(".order_done").click(function() {
                    $(this).prop("href", $(this).prop("href") + "?orderId=" + $(this).closest("tr").data("order"));
                });
            ';
        parent::init();
    }
}