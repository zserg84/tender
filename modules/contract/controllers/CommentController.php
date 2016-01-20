<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.04.15
 * Time: 12:31
 */

namespace modules\contract\controllers;

use modules\contract\models\Contract;
use modules\contract\models\ContractComment;
use modules\contract\models\form\CommentForm;
use modules\contract\widgets\actionButtons\comments\ResponseButton;
use modules\contract\widgets\actionButtons\comments\UpdateButton;
use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use modules\base\components\FrontendController;
use yii\web\Response;
use modules\contract\Module as ContractModule;

class CommentController extends FrontendController
{
    protected  $_buttons = [];
    /*
     * Комменты к чужим профилям
     * */
    const OTHER_PROFILE_LIST = 1;
    /*
     * Комменты к моему профилю
     * */
    const MY_PROFILE_LIST = 2;

    public function getButtons(){
        return $this->_buttons;
    }

    public function actionIndex($contractId){
        $contract = Contract::findOne($contractId);
        $comments = $contract ? $contract->contractComments : [];
        return $this->renderPartial('index', [
            'comments' => $comments,
            'contract' => $contract,
        ]);
    }

    public function actionList(){
        $this->_buttons = [
            ['class' => CustomerProfileButton::className(), 'params' =>[
                'title' => ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_PROFILE_BUTTON')
            ]],
            ['class' => UpdateButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = ContractComment::find()->where([
            'contract_id' => $curContract->id
        ]);
        $query->orderBy('contract_comment.created_at desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => 16
            ])
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'commentType' => self::OTHER_PROFILE_LIST
        ]);
    }

    public function actionMyProfileList(){
        $this->_buttons = [
            ['class' => CustomerProfileButton::className(), 'params' =>[
                'title' => ContractModule::t('CUSTOMER_INTERFACE', 'VIEW_ELEMENT_PERFORMER_PROFILE_BUTTON')
            ]],
            ['class' => ResponseButton::className(), 'params' =>[]],
        ];

        $curContract = Contract::getCurContract();
        $query = ContractComment::find()->where([
            'self_contract_id' => $curContract->id
        ]);
        $query->orderBy('contract_comment.created_at desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => 16
            ])
        ]);
        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'commentType' => self::MY_PROFILE_LIST
        ]);
    }

    public function actionGetList($contractId){
        $contract = Contract::findOne($contractId);
        $comments = $contract ? $contract->contractComments : [];
        return $this->renderPartial('_list', [
            'comments' => $comments,
        ]);
    }

    public function actionCreate(){
        $curContract = Contract::getCurContract();
        $model = new CommentForm();
        $post = \Yii::$app->getRequest()->post();
//        $this->performAjaxValidation($model);
        if($model->load($post)){
            $model->estimate = isset($post['estimate']) ? $post['estimate'] : $model->estimate;
            $contract = Contract::findOne($model->self_contract_id);
            if($model->validate()){
                $comment = new ContractComment();
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
        else{
            $contract = new Contract();
        }
        echo $this->renderAjax('_form', [
            'contract' => $contract,
        ]);
    }

    public function actionUpdate($id){
        $comment = ContractComment::findOne($id);
        $commentAuthorId = $comment->contract->getUser()->id;
        if (!\Yii::$app->user->can('updateOwnComments', ['userId' => $commentAuthorId])) {
            throw new Exception('Access denied');
        }
        $curContract = Contract::getCurContract();
        $model = new CommentForm();
        $model->setAttributes($comment->attributes);
        $contract = Contract::findOne($model->self_contract_id);
        $post = \Yii::$app->getRequest()->post();
        if($model->load($post)){
            $model->estimate = isset($post['estimate']) ? $post['estimate'] : $model->estimate;
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
            'contract' => $contract,
            'comment' => $comment,
        ]);
    }

    public function actionResponse($id){
        $parentComment = ContractComment::findOne($id);
        $curContract = Contract::getCurContract();
        $contract = Contract::findOne($parentComment->self_contract_id);
        $model = new CommentForm();
        $comment = new ContractComment();

        $post = \Yii::$app->getRequest()->post();
        if($model->load($post)){
            if($model->validate()){
                $comment->setAttributes($model->attributes);
                $comment->contract_id = $curContract->id;
                $comment->parent_id = $parentComment->id;
                if($comment->save()){
                    return $this->redirect(Url::toRoute(['/contract/comment/my-profile-list/']));
                }
            }
            else{
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return Json::encode(ActiveForm::validate($model));
            }
        }
        echo $this->renderAjax('response', [
            'model' => $model,
            'contract' => $contract,
            'parentComment' => $parentComment,
        ]);
    }

    protected function performAjaxValidation($model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $model->setScenario('ajax');
            return ActiveForm::validate($model);
        }
    }
} 