<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.10.15
 * Time: 11:04
 */

namespace modules\base\components;

//use vova07\admin\components\Controller;
use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['accessBackend'],
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action){
        if(!\Yii::$app->getUser()->can('accessBackend'))
            $this->redirect('/signup/');
        return parent::beforeAction($action);
    }
} 