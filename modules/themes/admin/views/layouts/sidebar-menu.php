<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use modules\themes\admin\widgets\Menu;
use modules\themes\Module;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            /*[
                'label' => Yii::t('modules/themes/admin', 'Dashboard'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl
            ],*/
            [
                'label' => Module::t('themes-admin', 'Users'),
                'url' => ['/users/default/index'],
                'icon' => 'fa-group',
                'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewUsers'),
            ],
            /*[
                'label' => Module::t('themes-admin', 'Static Pages'),
                'url' => ['/page/default/index'],
                'icon' => 'fa-square-o',
            ],*/
            [
                'label' => Module::t('themes-admin', 'Access control'),
                'url' => '#',
                'icon' => 'fa-gavel',
                'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewRoles') || Yii::$app->user->can('BViewPermissions') || Yii::$app->user->can('BViewRules'),
                'items' => [
                    [
                        'label' => Module::t('themes-admin', 'Permissions'),
                        'url' => ['/rbac/permissions/index'],
                        'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewPermissions')
                    ],
                    [
                        'label' => Module::t('themes-admin', 'Roles'),
                        'url' => ['/rbac/roles/index'],
                        'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewRoles')
                    ],
                    [
                        'label' => Module::t('themes-admin', 'Rules'),
                        'url' => ['/rbac/rules/index'],
                        'visible' => Yii::$app->user->can('administrateRbac') || Yii::$app->user->can('BViewRules')
                    ]
                ]
            ],
            [
                'label' => Module::t('themes-admin', 'Lang'),
                'url' => '#',
                'icon' => 'fa-language',
                'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewLang'),
                'items' => [
                    [
                        'label' => Module::t('themes-admin', 'Lang'),
                        'url' => ['/lang/default/index'],
                        'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewLang'),
                    ],
                    [
                        'label' => Module::t('themes-admin', 'Translations'),
                        'url' => ['/translations/default/index'],
                    ],
                ]
            ],
            [
                'label' => Module::t('themes-admin', 'Directions'),
                'url' => ['/direction/default/index'],
                'icon' => 'fa-arrow-up',
                'visible' => Yii::$app->user->can('administrateUsers') || Yii::$app->user->can('BViewDirection'),
            ],
            [
                'label' => 'Импорт/экспорт',
                'url' => '#',
                'icon' => 'fa-arrows-h',
                'items' => [
                    [
                        'label' => 'Импорт',
                        'url' => ['/exchange/default/import/'],
                    ],
                    [
                        'label' => 'Экспорт',
                        'url' => ['/exchange/default/export/'],
                    ]
                ]
            ],
            [
                'label' => 'Меню фронтенда',
                'url' => '#',
//                'icon' => 'fa-arrows-h',
                'active' => Yii::$app->controller->module->id == 'site',
                'items' => [
                    [
                        'label' => 'О проекте',
                        'url' => ['/site/about/index/'],
                        'active'=>\Yii::$app->controller->id == 'about',
                    ],
                    [
                        'label' => 'Новости',
                        'url' => ['/site/news/index/'],
                        'active'=>\Yii::$app->controller->id == 'news',
                    ],
                    [
                        'label' => 'Технологии',
                        'url' => ['/site/technology/index/'],
                        'active'=>\Yii::$app->controller->id == 'technology',
                    ],
                    [
                        'label' => 'Статьи',
                        'url' => ['/site/article/index/'],
                        'active'=>\Yii::$app->controller->id == 'article',
                    ],
                    [
                        'label' => 'Обучение',
                        'url' => ['/site/education/index/'],
                        'active'=>\Yii::$app->controller->id == 'education',
                    ],
                    /*[
                        'label' => 'Партнеры',
                        'url' => ['/site/partner/index/'],
                    ],
                    [
                        'label' => 'Контакты',
                        'url' => ['/site/contact/index/'],
                    ],*/
                ]
            ],
        ]
    ]
);