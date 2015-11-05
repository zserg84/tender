<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 03.06.15
 * Time: 12:53
 */

namespace modules\base\behaviors;

use modules\lang\models\Lang;
use yii\base\Behavior;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/*
 * Сохраняет связанные поля на разных языках
 * $relationName - имя связи с переводами
 * $formModel - форма с переводами
 * $translationFormField - имя поля-перевода в форме
 * $translationField - имя поля-перевода в таблице с переводами
 * $relationIdField - поле для связи модели с переводами и осн.модели
 * */
class LangSaveBehavior extends Behavior
{
    private $_is_init = false;

    public function saveLangsRelations($relationName, $formModel, $translationFormField, $translationField, $relationIdField){
        $owner = $this->owner;
        if(!$this->_is_init)
            $this->_initRelation($relationName, $relationIdField);
        $data = [];
        foreach($formModel->$translationFormField as $k=>$translationName){
            $data[$k] = [$translationField => $translationName];
        }

        if (Model::loadMultiple($owner->$relationName, $data, '') && Model::validateMultiple($owner->$relationName)) {
            $this->_saveRelation($relationName);
        }
        return $owner;
    }

    private function _initRelation($relationName, $relationIdField){
        $owner = $this->owner;
        $ownerClassName = $owner->className();
        $langModelClassName = $ownerClassName.'Lang';

        $modelLangs = [];
        $languages = Lang::find()->all();
        foreach ($languages as $languageModel) {
            $langId = $languageModel->id;
            $relation = $owner->$relationName;
            if (!isset($relation[$langId])) {
                $modelLang = new $langModelClassName();
                $modelLang->lang_id = $languageModel->id;
                $modelLang->$relationIdField = $owner->id;
                $modelLangs[$langId] = $modelLang;
            } else {
                $modelLangs[$langId] = $relation[$langId];
            }
        }
        $owner->populateRelation($relationName, $modelLangs);
        $this->_is_init = true;
    }

    public function _saveRelation($relationName)
    {
        $owner = $this->owner;
        foreach ($owner->$relationName as $modelLang) {
            $owner->link($relationName, $modelLang);
        }
    }
} 