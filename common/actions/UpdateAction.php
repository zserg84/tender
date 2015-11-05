<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.02.15
 * Time: 15:36
 */

namespace common\actions;


use yii\base\Exception;

class UpdateAction extends CreateAction{

    public $view = 'update';

    public function getModel(){
        $model = Action::findModel($this->modelClass, null, $this->modelIdName);
        return $model;
    }

    public function getFormModel(){
        $model = $this->getModel();
        $formModel = parent::getFormModel();
        $formModel->setAttributes($model->getAttributes(), false);
        return $formModel;
    }

} 