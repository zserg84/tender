<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.05.15
 * Time: 11:08
 */

namespace modules\contract\widgets\actionButtons\orders;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * Кнопка "Просмотр заказа"
 * */
class OrderLinkButton extends Button
{

    public function init()
    {
        if(\Yii::$app->getUser()->isGuest){
            $onlyReg = ContractModule::t('GUEST_INTERFACE', 'ACCES_DENIED_GUESTINTARFACE');;
            $this->button = Html::a(ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_BROWSING'), Url::toRoute(['/signup/']), [
                'data-confirm' => $onlyReg
            ]);
        }
        else{
            $contract = $this->model->contract;
            $company = $contract->performer;
            if(!$this->title){
                if($company){
                    $this->title = ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_BROWSING');
                }
                elseif($contract->customer){
                    $this->title = ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_BROWSING');
                }
            }
            $this->button = Html::a($this->title, "javascript:void(0)", [
                'class' => 'order_link'
            ]);

            $this->jsHandler = '
                $(".order_link").click(function() {
                    var url = "' . Url::toRoute(['/contract/order/view']) . '";
                    $.pjax({url: url, container: "#'.$this->pjaxContainerId.'", data:{orderId: $(this).closest("tr").data("order")}, push:false, replace:false});
                });

                $("#'.$this->pjaxContainerId.'").on("pjax:end", function() {
                    initPopup();
                    initPage();
                    $("#order-modal").modal();
                });
            ';
        }
        parent::init();
    }
}