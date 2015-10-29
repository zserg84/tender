<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.04.15
 * Time: 16:57
 */

namespace modules\contract\controllers\frontend;

use modules\contract\widgets\actionButtons\performers\FavoriteDeleteButton;
use modules\contract\widgets\actionButtons\performers\OfferOrderButton;
use modules\contract\widgets\actionButtons\performers\ProfileButton;

class PerformerController extends \modules\contract\controllers\PerformerController
{

    public function actionList(){
        $this->_buttons = [
            ['class' => ProfileButton::className(), 'params' =>[]],
            ['class' => OfferOrderButton::className(), 'params' =>[]],
            ['class' => FavoriteDeleteButton::className(), 'params' =>[]],
        ];

        return parent::actionList();
    }
}