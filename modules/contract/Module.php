<?php

namespace modules\contract;

use common\components\Menu;
use modules\themes\Module as ThemeModule;

class Module extends \modules\base\components\Module
{

    public static $langNames = [
        'ALL_INTERFACES', 'CUSTOMER_INTERFACE', 'REGISTRATION_FORM_PERFORMER', 'GUEST_INTERFACE', 'FORM_ORDER', 'PERFORMER_INTERFACE',
        'FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER'
    ];

    /**
     * @inheritdoc
     */
    public static $author = 'modules';

    /**
     * @inheritdoc
     */
    public static $name = 'contract';

    public static function getUserMenu(){
        $user = \Yii::$app->getUser();
        $items = [];
        if($user->getIsGuest() || $user->role == 'superadmin'){
            $items = [
                ['label' => ThemeModule::t('GUEST_INTERFACE', 'VIEW_PERFORMERS'), 'url' => ['/contract/performer/list']],
                ['label' => ThemeModule::t('GUEST_INTERFACE', 'VIEW_TAPE_OF_ORDERS'), 'url' => ['/contract/order/list']],
            ];
        }
        elseif($user->role == 'customer'){
            $items = [
                ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_PERFORMERS'), 'url' => ['/contract/performer/list'], 'items'=>[
                    ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_PERFORMER1'), 'url' => ['/contract/performer/list']],
                    ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_PERFORMER2'), 'url' => ['/contract/performer/list-favorite']],
                ], 'options' => ['class'=>'has']],
                ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS'), 'url' => ['/contract/order/list'], 'items' => [
                    ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS1'), 'url' => ['/contract/order/list']],
                    ['label' => ThemeModule::t('CUSTOMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS2'), 'url' => ['/contract/order/list-mine']],
                ], 'options' => ['class'=>'has']],
            ];
        }
        elseif($user->role == 'performer'){
            $items = [
                ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_PERFORMERS'), 'url' => ['/contract/performer/list'], 'items'=>[
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_PERFORMER1'), 'url' => ['/contract/performer/list']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_PERFORMER2'), 'url' => ['/contract/performer/list-competitor']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_PERFORMER3'), 'url' => ['/contract/performer/list-favorite']],
                ], 'options' => ['class'=>'has']],
                ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS'), 'url' => ['/contract/order/list'], 'items' => [
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS1'), 'url' => ['/contract/order/list']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS2'), 'url' => ['/contract/order/my-profile']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS3'), 'url' => ['/contract/order/list-my-response']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS4'), 'url' => ['/contract/order/list-work']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_TAPE_OF_ORDERS5'), 'url' => ['/contract/order/list-mine'],],
                ], 'options' => ['class'=>'has']],
                ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_COMMENTS'), 'url' => ['/contract/comment/list'], 'items' => [
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_COMMENTS1'), 'url' => ['/contract/comment/list']],
                    ['label' => ThemeModule::t('PERFORMER_INTERFACE', 'VIEW_COMMENTS2'), 'url' => ['/contract/comment-order/list']],
                ], 'options' => ['class'=>'has']],
            ];
        }

        $class = 'user-menu';
        if(\Yii::$app->getUser()->isGuest)
            $class .= ' guest';
        return Menu::widget([
            'items' => $items,
            'options' => [
                'class' => $class,
            ],
            'itemOptions' =>[
//                'class' => 'has',
            ],
            'submenuTemplate' => "<div class='clearfix'></div><ul class='user-submenu'>\n{items}\n</ul>\n",
        ]);
    }
}