<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 30.04.15
 * Time: 16:50
 */

namespace modules\contract\controllers;


use modules\contract\models\Contract;
use modules\contract\models\form\OrderCommentForm;
use modules\contract\models\Order;
use modules\contract\models\OrderComment;
use modules\contract\widgets\actionButtons\comments\OrderResponseButton;
use modules\contract\widgets\actionButtons\comments\OrderUpdateButton;
use modules\contract\widgets\actionButtons\comments\ResponseButton;
use modules\contract\widgets\actionButtons\comments\UpdateButton;
use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use modules\contract\widgets\actionButtons\orders\OrderLinkButton;
use modules\site\components\Controller;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Json;
use modules\contract\Module as ContractModule;
use yii\helpers\Url;
use yii\web\Response;

class CommentOrderController extends Controller
{
    /*
     * Комменты к чужим заказам
     * */
    const OTHER_ORDERS_LIST = 1;
    /*
     * Комменты к моему заказу
     * */
    const MY_ORDERS_LIST = 2;

    protected  $_buttons = [];

    public function getButtons(){
        return $this->_buttons;
    }

    public function actionIndex($orderId){
        $order = Order::findOne($orderId);
        $comments = $order ? $order->orderComments : [];
        echo $this->renderPartial('index', [
            'comments' => $comments,
            'order' => $order,
        ]);
    }

    public function actionList(){
        $this->_buttons = [
            ['class' => CustomerProfileButton::className(), 'params' =>[
                'title' => ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_PROFILE_BUTTON')
            ]],
            ['class' => OrderLinkButton::className(), 'params' =>[
                'title' => ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_ORDER')
            ]],
            ['class' => OrderUpdateButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = OrderComment::find()->andWhere([
            'contract_id' => $curContract->id
        ]);
        $query->orderBy('order_comment.created_at desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => 16
            ])
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'commentType' => self::OTHER_ORDERS_LIST
        ]);
    }

    public function actionMyOrdersList(){
        $this->_buttons = [
            ['class' => CustomerProfileButton::className(), 'params' =>[
                'title' => ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_PROFILE_BUTTON')
            ]],
            ['class' => OrderLinkButton::className(), 'params' =>[
                'title' => ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_ORDER')
            ]],
            ['class' => OrderResponseButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = OrderComment::find()->innerJoinWith([
            'order' => function($query) use($curContract){
                $query->andWhere([
                    'order.contract_id' => $curContract->id
                ]);
            }
        ]);
        $query->orderBy('order_comment.created_at desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => 16
            ])
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'commentType' => self::MY_ORDERS_LIST
        ]);
    }

    public function actionGetList($orderId){
        $order = Order::findOne($orderId);
        $comments = $order ? $order->orderComments : [];
        echo $this->renderPartial('_list', [
            'comments' => $comments,
        ]);
    }

    public function actionCreate(){
        $curContract = Contract::getCurContract();
        $model = new OrderCommentForm();
        $post = \Yii::$app->getRequest()->post();
        if($model->load($post)){
            $order = Order::findOne($model->order_id);
            if($model->validate()){
                $comment = new OrderComment();
                $comment->setAttributes($model->attributes);
                $comment->contract_id = $curContract->id;
                $comment->order_id = $order->id;
                if($comment->save()){
                    return Json::encode(['output'=>'success']);
                }
            }
            else{
                \Yii::$app->response->setStatusCode(400);
                return Json::encode(['output'=>'error', 'error' => ActiveForm::validate($model)]);
            }
        }
        else{
            $order = new Order();
        }
        echo $this->renderAjax('_form', [
            'order' => $order,
        ]);
    }

    public function actionUpdate($id){
        $comment = OrderComment::findOne($id);
        $commentAuthorId = $comment->contract->getUser()->id;
        if (!\Yii::$app->user->can('updateOwnComments', ['userId' => $commentAuthorId])) {
            throw new Exception('Access denied');
        }
        $curContract = Contract::getCurContract();
        $model = new OrderCommentForm();
        $model->setAttributes($comment->attributes);
        $order = Order::findOne($model->order_id);
        $post = \Yii::$app->getRequest()->post();
        if($model->load($post)){
            if($model->validate()){
                $comment->setAttributes($model->attributes);
                $comment->contract_id = $curContract->id;
                if($comment->save()){
                    return Json::encode(['output'=>'success']);
                }
            }
            else{
                \Yii::$app->response->setStatusCode(400);
                return Json::encode(['output'=>'error', 'error' => ActiveForm::validate($model)]);
            }
        }
        echo $this->renderPartial('update', [
            'model' => $model,
            'order' => $order,
            'comment' => $comment,
        ]);
    }

    public function actionResponse($id){
        $parentComment = OrderComment::findOne($id);
        $curContract = Contract::getCurContract();
        $model = new OrderCommentForm();
        $comment = new OrderComment();

        $post = \Yii::$app->getRequest()->post();
        if($model->load($post)){
            $model->order_id = $parentComment->order_id;
            if($model->validate()){
                $comment->setAttributes($model->attributes);
                $comment->contract_id = $curContract->id;
                $comment->parent_id = $parentComment->id;
                if($comment->save()){
                    return $this->redirect(Url::toRoute(['/contract/comment-order/my-orders-list/']));
                }
            }
            else{
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return Json::encode(ActiveForm::validate($model));
            }
        }
        echo $this->renderAjax('response', [
            'model' => $model,
            'parentComment' => $parentComment,
        ]);
    }
} 