<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.02.15
 * Time: 14:39
 */

namespace common\actions;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CreateAction extends Action {

    public $view = 'create';

    public $ajaxValidation = false;

    public $formModelClass;

    public function run(){

        $model = $this->getModel();

        $formModel = $this->getFormModel();

        if($beforeAction = $this->beforeAction){
            $formModel = call_user_func($beforeAction, $this, $model, $formModel);
        }

        if($post = \Yii::$app->getRequest()->post()){
            $this->loadData($formModel, $post);
            if (Yii::$app->getRequest()->isAjax and $this->ajaxValidation) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $scenarios = $formModel->scenarios();
                $formModel->scenario = isset($scenarios['ajax']) ? 'ajax' : Model::SCENARIO_DEFAULT;
                return ActiveForm::validate($formModel);
            }

            $model->setAttributes($formModel->attributes, false);

            if($formModel->validate() && $model->save()){
                if($afterAction = $this->afterAction){
                    $model = call_user_func($afterAction, $this, $model, $formModel);
                }
                if($this->accessMsg) {
                    \Yii::$app->session->setFlash('message', $this->accessMsg);
                }
                if($this->redirectUrl){
                    $this->controller->redirect($this->redirectUrl);
                }
            }
            else{
                if($this->errorMsg){
                    \Yii::$app->session->setFlash('message', $this->errorMsg);
                }
            }
        }
        $viewParams = array_merge(['model'=>$model, 'formModel' => $formModel], $this->viewParams);
        $viewParams['viewParams'] = $viewParams;
        if(\Yii::$app->getRequest()->isAjax) { // or isPjax
            return $this->controller->renderAjax($this->view, $viewParams);
        }
        return $this->controller->render($this->view, $viewParams);
    }

    public function getModel(){
        return new $this->modelClass;
    }

    public function getFormModel(){
        $formModelClass = $this->formModelClass ? $this->formModelClass : $this->modelClass;
        $formModel = new $formModelClass;
        return $formModel;
    }

    public function loadData($model, $post){
        $model->load($post);
    }
} 