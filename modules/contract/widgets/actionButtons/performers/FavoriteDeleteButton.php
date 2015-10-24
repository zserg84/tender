<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.05.15
 * Time: 12:13
 */

namespace modules\contract\widgets\actionButtons\performers;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

class FavoriteDeleteButton extends Button
{

    public function init()
    {
        if(\Yii::$app->getUser()->isGuest){
            $onlyReg = ContractModule::t('GUEST_INTERFACE', 'ACCES_DENIED_GUESTINTARFACE');;
            $this->button = Html::a(ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_REMOVE_BUTTON'), Url::toRoute(['/signup/']), [
                'data-confirm' => $onlyReg
            ]);
        }
        else{
            $this->button = Html::a(ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_REMOVE_BUTTON'), Url::toRoute(['favorite-delete', 'favoriteContractId' => $this->model->id]), [
                'data-confirm' => ContractModule::t('PERFORMER_INTERFACE', 'SERVICE_MESSAGE_REMOVE_FROM_MY_FAVORITES_PERF_INTERFACE')
            ]);
        }

        parent::init();
    }
} 