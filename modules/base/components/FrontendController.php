<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.11.15
 * Time: 15:32
 */

namespace modules\base\components;


use modules\base\behaviors\ReturnUrlFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class FrontendController extends Controller
{

    public $accessForGuest = false;

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
                        'roles' => ['user']
                    ]
                ]
            ],
            'returnUrl' => [
                'class' => ReturnUrlFilter::className(),
            ],
        ];
    }

    public function beforeAction($action){
        if(\Yii::$app->getUser()->isGuest && !$this->accessForGuest)
            $this->redirect('/');
        return parent::beforeAction($action);
    }
} 