<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.04.15
 * Time: 16:57
 */

namespace modules\contract\controllers\performer;

use modules\contract\widgets\actionButtons\performers\FavoriteAddButton;
use modules\contract\widgets\actionButtons\performers\FavoriteDeleteButton;
use modules\contract\widgets\actionButtons\performers\OfferOrderButton;
use modules\contract\widgets\actionButtons\performers\ProfileButton;

class PerformerController extends \modules\contract\controllers\PerformerController
{

    public function actionList(){
        $this->_buttons = [
            ['class' => ProfileButton::className(), 'params' =>[]],
            ['class' => OfferOrderButton::className(), 'params' =>[]],
            ['class' => FavoriteAddButton::className(), 'params' =>[]],
        ];

        return parent::actionList();
    }

    public function actionListFavorite(){
        $this->_buttons = [
            ['class' => ProfileButton::className(), 'params' =>[]],
            ['class' => OfferOrderButton::className(), 'params' =>[]],
            ['class' => FavoriteDeleteButton::className(), 'params' =>[]],
        ];

        return parent::actionListFavorite();
    }

    public function actionListCompetitor(){
        $this->_buttons = [
            ['class' => ProfileButton::className(), 'params' =>[]],
            ['class' => OfferOrderButton::className(), 'params' =>[]],
            ['class' => FavoriteAddButton::className(), 'params' =>[]],
        ];

        $dataProvider = $this->getPerformerList([
            'competitors' => 1
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'favorite' => 0,
        ]);
    }
} 