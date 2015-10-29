<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.04.15
 * Time: 12:31
 */

namespace modules\contract\controllers\performer;

use modules\contract\Module as ContractModule;
use modules\contract\models\Contract;
use modules\contract\models\ContractComment;
use modules\contract\widgets\actionButtons\comments\ResponseButton;
use modules\contract\widgets\actionButtons\comments\UpdateButton;
use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use modules\contract\widgets\actionButtons\performers\ProfileButton;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class CommentController extends \modules\contract\controllers\CommentController
{

    public function actionList(){
        $this->_buttons = [
            ['class' => CustomerProfileButton::className(), 'params' =>[
                'title' => ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_PROFILE_BUTTON')
            ]],
            ['class' => UpdateButton::className(), 'params' =>[]],
            ['class' => ResponseButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = ContractComment::find()->where([
            'self_contract_id' => $curContract->id
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => 20
            ])
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }
} 