<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 07.05.15
 * Time: 16:47
 */

namespace modules\contract\widgets\settings;

use modules\contract\models\Contract;
use modules\contract\models\ContractSettings;
use modules\contract\models\form\customer\SettingsForm;
use yii\bootstrap\Widget;

class SettingsWidget extends Widget
{

    public function run(){

        $curContract = Contract::getCurContract();
        if($curContract->contractType == 'customer'){
            $model = new \modules\contract\models\form\customer\SettingsForm();
            $view = 'customer';
        }
        elseif($curContract->contractType == 'performer'){
            $model = new \modules\contract\models\form\performer\SettingsForm();
            $view = 'performer';
        }

        $setting = $curContract->getContractSetting();
        $setting = $setting ? $setting : new ContractSettings();
        return $this->render($view, [
            'model' => $model,
            'setting' => $setting,
        ]);
//        $contractModule = \Yii::$app->getModule('contract');
//        return $contractModule->runAction('settings/update');
    }
} 