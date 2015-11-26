<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.11.15
 * Time: 15:04
 */

namespace modules\contract\widgets\actionButtons\orders;


use modules\contract\widgets\actionButtons\Button;
use yii\bootstrap\Html;
use modules\contract\Module as ContractModule;
use yii\helpers\Url;

class OrderResponsesButton extends Button
{

    public function init()
    {
        $this->button = Html::a(ContractModule::t('ALL_INTERFACES', 'VIEW_ELEMENT_TAPE_OF_ORDERS_RESPONSES_BUTTON'), "javascript:void(0)", [
            'class' => 'order_responses_link'
        ]);

        $this->jsHandler = '
            $(".order_responses_link").click(function(){
                var order = $(this).closest("tr").data("order");
                var url = "'.Url::toRoute(['responses']).'?orderId=" + order ;
                $.pjax({
                    url: url,
                    container: "#'.$this->pjaxContainerId.'",
                    push:false,
                    replace:false
                });
            });

            $("#'.$this->pjaxContainerId.'").on("pjax:end", function() {
                initPopup();
                initPage();
                $("#response-list-popup").modal();
            });
        ';

        parent::init();
    }
} 