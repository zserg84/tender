<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.02.15
 * Time: 15:48
 */

namespace common\actions;


use yii\web\ServerErrorHttpException;

class DeleteAction extends Action{

    public function run(){
        $model = $this->getModel();

        if($model->delete()){
            if($this->redirectUrl){
                $this->controller->redirect($this->redirectUrl);
                \Yii::$app->end();
            }
            return true;
        }
        else{
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }

    public function loadData($model, $post){

    }
} 