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
use modules\contract\models\OrderComment;
use modules\contract\widgets\actionButtons\comments\ResponseButton;
use modules\contract\widgets\actionButtons\comments\UpdateButton;
use modules\contract\widgets\actionButtons\orders\OrderLinkButton;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\VarDumper;

class CommentOrderController extends \modules\contract\controllers\CommentOrderController
{

    public function actionList(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[
                'title' => ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_ORDER')
            ]],
            ['class' => UpdateButton::className(), 'params' =>[]],
            ['class' => ResponseButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = OrderComment::find()->innerJoinWith([
            'order' => function($query) use($curContract){
                $query->andWhere([
                    'order.contract_id' => $curContract->id
                ]);
            }
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