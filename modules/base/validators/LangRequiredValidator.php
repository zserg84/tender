<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 17.06.15
 * Time: 10:45
 */

namespace modules\base\validators;


use modules\lang\models\Lang;
use yii\base\Exception;
use yii\validators\Validator;

/*
 * Валидатор делает обязательным только те поля, которые указаны в $langsUrl
 * */
class LangRequiredValidator extends Validator
{

    /*
     * Является ли обязательным поле с текущим языком системы
     * */
    public $currentLangRequired = true;

    /*
     * Массив с урлами языков для обязательных полей
     * */
    public $langUrls = ['current'];

    private $_langs = [];

    public function init(){
        parent::init();

        if(!is_array($this->langUrls))
            $this->langUrls = [$this->langUrls];

        if($this->currentLangRequired && !array_search('current', $this->langUrls))
            $this->langUrls[] = 'current';

//        if($k = array_search('current', $this->langUrls)){
//            $lang = Lang::getCurrent();
//            $this->langUrls[$k] = $lang->url;
//        }

        foreach($this->langUrls as $k=>$langUrl){
            if($langUrl == 'current'){
                $this->_langs[$k] = Lang::getCurrent();
            }
            else{
                $lang = Lang::find()->where([
                    'url' => $langUrl
                ])->one();
                $this->_langs[$k] = $lang;
            }
        }
    }

    public function validateAttribute($model, $attribute)
    {
        foreach($this->_langs as $lang){
            $langAttr = $attribute.'['.$lang->id.']';
            $attributes = $model->$attribute;
            $langAttrValue = isset($attributes[$lang->id]) ? $attributes[$lang->id] : null;
            if(!$langAttrValue)
                $model->addError($langAttr, \Yii::t('yii', '{attribute} cannot be blank.', ['attribute'=>$model->getAttributeLabel($attribute)]));
        }
    }

    public function getLangs(){
        return $this->_langs;
    }
}