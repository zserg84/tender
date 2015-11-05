<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 15:50
 */

namespace modules\users\widgets\profile;


use modules\contract\models\Contract;
use modules\users\models\frontend\User;
use yii\base\Widget;

class ProfileWidget extends Widget
{

    public function run(){

        $curContract = Contract::getCurContract();
        if($curContract->contractType == 'customer'){
            $model = new \modules\users\models\customer\UserForm();
            $view = 'customer';
        }
        elseif($curContract->contractType == 'performer'){
            $model = new \modules\users\models\performer\UserForm();
            $view = 'performer';
        }

        $userId = \Yii::$app->getUser()->id;
        $user = User::findOne($userId);
        $model->user = $user;
        $contracts = $user->performerContracts;
        $contract = $contracts? $contracts[0] : new Contract();

        return $this->render($view, [
            'model' => $model,
            'user' => $user,
            'contract' => $contract,
        ]);
    }
} 