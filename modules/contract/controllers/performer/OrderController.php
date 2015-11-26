<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.04.15
 * Time: 10:29
 */

namespace modules\contract\controllers\performer;

use modules\base\behaviors\ReturnUrlFilter;
use modules\contract\models\Contract;
use modules\contract\models\ContractOrder;
use modules\contract\models\OfferToCustomer;
use modules\contract\models\Order;
use modules\contract\widgets\actionButtons\orders\OrderDoneButton;
use modules\contract\widgets\actionButtons\orders\OrderLinkButton;
use modules\contract\widgets\actionButtons\orders\OrderResponsesButton;
use modules\contract\widgets\actionButtons\orders\RefuseButton;
use modules\contract\widgets\actionButtons\orders\ResponseDeleteButton;
use modules\contract\widgets\actionButtons\orders\ResponseOrderLinkButton;
use modules\contract\widgets\actionButtons\orders\UpdateButton;
use performer\components\PerformerTrait;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class OrderController extends \modules\contract\controllers\OrderController
{

    use PerformerTrait;

    public function actionList(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => ResponseOrderLinkButton::className(), 'params' =>[]],
        ];

        return parent::actionList();
    }

    public function actionListMyResponse(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => ResponseDeleteButton::className(), 'params' =>[]],
        ];

        $dataProvider = $this->getOrderList([
            'withMyResponse' => true,
            'visibleStatuses' => [
                Order::STATUS_OPEN, Order::STATUS_PREPARED, Order::STATUS_CLOSE, Order::STATUS_REFUSE, Order::STATUS_TEMP_REMOVE, Order::STATUS_FINISHED
            ]
        ]);
        return $this->render('list',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListMine(){
        $this->_buttons = [
            ['class' => UpdateButton::className(), 'params' =>[]],
            ['class' => OrderResponsesButton::className(), 'params' =>[]],
        ];

        return parent::actionListMine();
    }

    public function actionListOffers(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => ResponseOrderLinkButton::className(), 'params' =>[]],
        ];
        $dataProvider = $this->getOrderList([
            'offersToMe' => true,
        ]);

        return $this->render('list',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListWork(){
        $this->_buttons = [
            ['class' => OrderLinkButton::className(), 'params' =>[]],
            ['class' => OrderDoneButton::className(), 'params' =>[]],
            ['class' => RefuseButton::className(), 'params' =>[]],
        ];
        $dataProvider = $this->getOrderList([
            'toWork' => true,
            'visibleStatuses' => [Order::STATUS_WORK],
        ]);
        return $this->render('list',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyProfile(){
        $dataProvider = $this->getOrderList([
            'myProfile' => true,
        ]);
        return $this->render('list',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRefuse($orderId){
        $curContract = Contract::getCurContract();
        $order = Order::findOne($orderId);
        if($order) {
            $order->status = Order::STATUS_REFUSE;
            $order->save();

            $contractOrder = ContractOrder::findOne([
                'contract_id'=> $curContract->id,
                'order_id' => $order->id,
            ]);
            if($contractOrder)
                $contractOrder->delete();
        }
        $this->redirect(Url::toRoute(['order/list-work']));
    }

    public function actionResponse($orderId){
        $order = Order::findOne($orderId);
        $model = new OfferToCustomer();

//        $this->performAjaxValidation($model);

        if($model->load(\Yii::$app->getRequest()->post())){
            $curContract = Contract::getCurContract();
            $offerToCustomer = OfferToCustomer::find()->where([
                'order_id' => $orderId,
                'contract_id' => $curContract->id,
            ])->one();
            if($offerToCustomer){
                return $this->redirect(Url::toRoute(['list']));
            }
            $model->contract_id = $curContract->id;
            $model->order_id = $orderId;
            if($model->save()){
                $order->status = Order::STATUS_WORK;
                return $this->redirect(Url::toRoute(['list']));
            }
            else{
                return Json::encode([ActiveForm::validate($model)]);
            }
        }

        echo $this->renderAjax('response', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    public function actionResponseDelete($orderId){
        $curContract = Contract::getCurContract();
        $offerToCustomer = OfferToCustomer::find()->where([
            'order_id' => $orderId,
            'contract_id' => $curContract->id,
        ])->one();
        $offerToCustomer->delete();

        return $this->redirect(Url::toRoute(['list-my-response']));
    }

    public function actionStatusDone($orderId){
        $order = Order::findOne($orderId);
        $curContract = Contract::getCurContract();
        $contractOrder = ContractOrder::findOne([
            'order_id' => $orderId,
            'contract_id' => $curContract->id
        ]);

        if($order->status == Order::STATUS_WORK && $contractOrder){
            $order->status = ORDER::STATUS_DONE;
            $order->save(false, ['status']);
        }
        $this->redirect(Url::toRoute(['list-work']));
    }
} 