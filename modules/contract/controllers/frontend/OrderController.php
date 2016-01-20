<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.04.15
 * Time: 10:29
 */

namespace modules\contract\controllers\frontend;

use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use modules\contract\widgets\actionButtons\orders\OrderLinkButton;
use modules\contract\widgets\actionButtons\orders\ResponseOrderLinkButton;
use yii\helpers\VarDumper;

class OrderController extends \modules\contract\controllers\OrderController
{
    public $accessForGuest = true;

    public function actionList(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => CustomerProfileButton::className(), 'params' =>[]],
            ['class' => ResponseOrderLinkButton::className(), 'params' =>[]],
        ];
        return parent::actionList();
    }
} 