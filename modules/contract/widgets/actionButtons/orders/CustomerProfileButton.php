<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.05.15
 * Time: 11:24
 */

namespace modules\contract\widgets\actionButtons\orders;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * Кнопка "Профиль заказчика"
 * */
class CustomerProfileButton extends Button
{

    public function init()
    {
        if(\Yii::$app->getUser()->isGuest){
            $onlyReg = ContractModule::t('GUEST_INTERFACE', 'ACCES_DENIED_GUESTINTARFACE');
            $this->button = Html::a(ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_CUSTOMER_PROFILE'), Url::toRoute(['/signup/']), [
                'data-confirm' => $onlyReg
            ]);
        }
        else{
            $contract = $this->model->contract;
            $company = $contract->performer;
            $profileClass = 'error';
            $title = '';
            if($company){
                $profileClass = 'performer';
                $title = ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_CUSTOMER_PROFILE');
            }
            elseif($contract->customer){
                $profileClass = 'customer';
                $title = ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUTTON_CUSTOMER_PROFILE');
            }

            $this->button = Html::a($title, "javascript:void(0)", [
                'class' => 'profile_link ' .$profileClass
            ]);

            $this->jsHandler = '
                $(".profile_link.performer").click(function() {
                    var url = "'.Url::toRoute(['/contract/performer/profile']).'";
                    $.pjax({
                        url: url,
                        container: "#'.$this->pjaxContainerId.'",
                        data:{contractId: $(this).closest("tr").data("contract"), orderId: $(this).closest("tr").data("order")},
                        push:false,
                        replace:false
                    });
                });
                $(".profile_link.customer").click(function() {
                    var url = "'.Url::toRoute(['/contract/customer/profile']).'";
                    $.pjax({
                        url: url,
                        container: "#'.$this->pjaxContainerId.'",
                        data:{contractId: $(this).closest("tr").data("contract")},
                        push:false,
                        replace:false
                    });
                });
                $(".profile_link.error").click(function() {
                    alert("Профиль недоступен");
                });

                $("#pjax-order-modal-container").on("pjax:end", function() {
                    initPopup();
                    initPage();
                    $("#profile-modal").modal();
                });
            ';
        }


        parent::init();
    }
} 