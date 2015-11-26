<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 13.11.15
 * Time: 17:13
 */

namespace modules\base\behaviors;


use yii\base\ActionFilter;
use yii\helpers\Url;

class ReturnUrlFilter extends ActionFilter
{
    const RETURN_URL_PARAM = '__returnUrlFilter';

    public function beforeAction($action){
        if(parent::beforeAction($action)){
            Url::remember(Url::current(), self::RETURN_URL_PARAM);
        }
        return true;
    }
} 