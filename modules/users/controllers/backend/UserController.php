<?php

namespace modules\users\controllers\backend;

use modules\base\components\BackendController;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Backend controller for authenticated users.
 */
class UserController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Logout user.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/');
    }
}
