<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 10.06.15
 * Time: 14:01
 */

namespace modules\base\behaviors;


use modules\lang\models\Lang;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/*
 * Behavior для перевода полей модели на нужный язык
 * */
class TranslateBehavior extends Behavior
{

    private $_translateModel;

    /*
     * имя модели с переводами (например, CityLang::className())
     * */
    public $translateModelName;

    /*
     * имя поля для связи с моделью с переводами(например, city_id)
     * */
    public $relationFieldName;

    /*
     * массив с полями для перевода
     * */
    public $translateFieldNames = [];

    /*
     * Сокращённое название языка
     * */
    public $langUrl;

    public function events(){
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    /*
     * Возвращает модель с переводами
     * */
    protected function _getTranslateModel($translateModelName, $relationFieldName, $lang){
        $owner = $this->owner;
        $tableName = $translateModelName::tableName();
        $translateModel = $translateModelName::find()->where([
            $tableName.'.lang_id' => $lang->id,
            $relationFieldName => $owner->id,
        ])->one();

        return $translateModel;
    }

    public function getTranslateModel(){
        if(!$this->_translateModel){
            $translateModelName = $this->translateModelName;
            $relationFieldName = $this->relationFieldName;
            if(!$this->langUrl){
                $lang = Lang::getCurrent();
            }
            else{
                $lang = Lang::find()->where(['url' => $this->langUrl])->one();
            }
            $this->_translateModel = $this->_getTranslateModel($translateModelName, $relationFieldName, $lang);
        }
        return $this->_translateModel;
    }

    /*
     * Переводит поля на нужный язык
     * */
    public function translate($translateFieldName){
        $owner = $this->owner;
        $translateModel = $this->getTranslateModel();
        if($translateModel){
            $owner->$translateFieldName = $translateModel->$translateFieldName;
            return $translateModel->$translateFieldName;
        }
        return null;
    }

    public function afterFind(){
        foreach($this->translateFieldNames as $translateFieldName){
            $this->translate($translateFieldName);
        }
    }

}