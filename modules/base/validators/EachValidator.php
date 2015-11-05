<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 17.06.15
 * Time: 11:13
 */

namespace modules\base\validators;


use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\validators\FilterValidator;
use yii\validators\Validator;

class EachValidator extends \yii\validators\EachValidator
{
    private $_validator;

    protected function getValidator($model = null)
    {
        if ($this->_validator === null) {
            $this->_validator = $this->createEmbeddedValidator($model);
        }
        return $this->_validator;
    }

    protected function createEmbeddedValidator($model)
    {
        $rule = $this->rule;
        if ($rule instanceof Validator) {
            return $rule;
        } elseif (is_array($rule) && isset($rule[0])) { // validator type
            if (!is_object($model)) {
                $model = new Model(); // mock up context model
            }
            return Validator::createValidator($rule[0], $model, $this->attributes, array_slice($rule, 1));
        } else {
            throw new InvalidConfigException('Invalid validation rule: a rule must be an array specifying validator type.');
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $validator = $this->getValidator();
        if ($validator instanceof FilterValidator && is_array($value)) {
            $filteredValue = [];
            foreach ($value as $k => $v) {
                if (!$validator->skipOnArray || !is_array($v)) {
                    $filteredValue[$k] = call_user_func($validator->filter, $v);
                }
            }
            $model->$attribute = $filteredValue;
        } else {
            $this->getValidator($model); // ensure model context while validator creation
            $this->validateAttr($model, $attribute);
        }
    }

    public function validateAttr($model, $attribute)
    {
        $results = $this->validateValue($model->$attribute);
        $value = $model->$attribute;
        $params['attribute'] = $model->getAttributeLabel($attribute);
        $params['value'] = is_array($value) ? 'array()' : $value;
        foreach ($results as $k=>$result) {
            if (!empty($result)) {
                $params = array_merge($result[1], $params);
                $message = \Yii::$app->getI18n()->format($result[0], $params, \Yii::$app->language);
                $model->addError($attribute.'['.$k.']', $message, $params);
            }
        }
    }

    protected function validateValue($value)
    {
        if (!is_array($value)) {
            return [[$this->message, []]];
        }

        $validator = $this->getValidator();
        $results = [];
        foreach ($value as $k=>$v) {
            $result = $validator->validateValue($v);
            if ($result !== null) {
                $result = $this->allowMessageFromRule ? $result : [$this->message, []];
                $results[$k] = $result;
            }
        }
        return $results;
    }
} 