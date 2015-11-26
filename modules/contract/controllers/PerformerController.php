<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.04.15
 * Time: 16:57
 */

namespace modules\contract\controllers;

use modules\base\components\FrontendController;
use modules\contract\models\Contract;
use modules\contract\models\ContractOrder;
use modules\contract\models\FavoriteCompany;
use modules\contract\models\OfferToPerformer;
use modules\contract\models\Order;
use modules\contract\models\search\PerformerSearch;
use yii\base\Exception;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use \yii\web\Controller;

class PerformerController extends FrontendController
{
    protected  $_buttons = [];

    public function getButtons(){
        return $this->_buttons;
    }

    public function actionList(){
        $dataProvider = $this->getPerformerList();
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'favorite' => 0,
        ]);
    }

    public function getPerformerList($params = []){
        $model = new PerformerSearch();
        $params = array_merge(\Yii::$app->getRequest()->post(), $params);
        return $model->search($params);
    }

    public function actionProfile($contractId){
        $orderId = \Yii::$app->getRequest()->get('orderId');
        $order = Order::findOne($orderId);
        $model = Contract::findOne($contractId);
        echo $this->renderAjax('_profile_view', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    public function actionListFavorite(){
        $dataProvider = $this->getPerformerList([
            'favorite' => 1,
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'favorite' => 1,
        ]);
    }

    public function actionFavoriteAdd($favoriteContractId){
        $currentContract = Contract::getCurContract();
        $favorite = FavoriteCompany::find()->where([
            'contract_id' => $currentContract->id,
            'favorite_contract_id' => $favoriteContractId,
        ])->one();
        if(!$favorite){
            $favorite = new FavoriteCompany();
            $favorite->contract_id = $currentContract->id;
            $favorite->favorite_contract_id = $favoriteContractId;
            $favorite->save();
        }
        $this->redirect(Url::toRoute(['list']));
    }

    public function actionFavoriteDelete($favoriteContractId){
        $currentContract = Contract::getCurContract();
        $favorite = FavoriteCompany::find()->where([
            'contract_id' => $currentContract->id,
            'favorite_contract_id' => $favoriteContractId,
        ])->one();
        if($favorite){
            $favorite->delete();
        }
        $this->redirect(Url::toRoute(['list-favorite']));
    }

    public function actionOfferOrder($contractId){
        $currentContract = Contract::getCurContract();
        $orders = Order::find()->where([
            'contract_id' => $currentContract->id,
            'status' => Order::STATUS_OPEN
        ])->all();
        $model = Contract::findOne($contractId);

        if(\Yii::$app->getRequest()->post()){
            $orders = \Yii::$app->getRequest()->post('order', []);
            foreach($orders as $orderId){
                $otp = OfferToPerformer::find()->where([
                    'contract_id' => $contractId,
                    'order_id' => $orderId,
                ])->one();
                if($otp)
                    continue;
                $otp = new OfferToPerformer();
                $otp->order_id = $orderId;
                $otp->contract_id = $contractId;
                $otp->save();

                /*$order = Order::findOne($orderId);
                $order->status = Order::STATUS_WORK;
                $order->save();*/
            }
            $this->redirect(Url::toRoute(['list']));
        }

        echo $this->renderAjax('_offer_order', [
            'model' => $model,
            'orders' => $orders,
        ]);
    }

    public function actionChoosePerformer($orderId, $contractId){
        $order = Order::findOne($orderId);
        $curContract = Contract::getCurContract();
        if($order->contract_id != $curContract->id)
            throw new Exception('Access denied');
        $contractOrder = ContractOrder::findOne([
            'order_id' => $orderId,
        ]);
        if(!$contractOrder){
            $contractOrder = new ContractOrder();
            $contractOrder->contract_id = $contractId;
            $contractOrder->order_id = $orderId;
            if($contractOrder->save()){
                $order->status = Order::STATUS_WORK;
                $order->save(false, ['status']);
            }
        }
        return $contractOrder->contract_id;
    }
} 