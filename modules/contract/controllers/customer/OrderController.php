<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.04.15
 * Time: 10:29
 */

namespace modules\contract\controllers\customer;

use customer\components\CustomerTrait;
use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use modules\contract\widgets\actionButtons\orders\OrderLinkButton;

class OrderController extends \modules\contract\controllers\OrderController
{

    use CustomerTrait;

    public function actionList(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => CustomerProfileButton::className(), 'params' =>[]],
        ];

        return parent::actionList();
    }

    public function actionListMine(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => CustomerProfileButton::className(), 'params' =>[]],
        ];

        return parent::actionListMine();
    }
} 