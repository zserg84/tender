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
            $onlyReg = 'Просмотр информации возможен только зарегистрированными пользователями';
            $this->button = Html::a(ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_REMOVE_BUTTON'), Url::toRoute(['/signup/']), [
                'data-confirm' => $onlyReg
            ]);
        }
        else{
            $this->button = Html::a(ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_REMOVE_BUTTON'), Url::toRoute(['favorite-delete', 'favoriteContractId' => $this->model->id]), [
                'data-confirm' => "Вы подтвержаете удаление исполнителя ?"
            ]);
        }

        parent::init();
    }
} 