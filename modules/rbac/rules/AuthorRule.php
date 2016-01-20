<?php

namespace modules\rbac\rules;

use yii\helpers\VarDumper;
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'author';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {return true;
        if (\Yii::$app->user->can('superadmin')) {
            return true;
        }
        if(isset($params['model'])){
            $model = $params['model'];
            if(isset($model['author_id'])){
                return $params['model']['author_id'] == $user;
            }
            if(isset($model['user_id'])){
                return $params['model']['user_id'] == $user;
            }
        }
        elseif(isset($params['userId'])){
            return $params['userId'] == $user;
        }
        return false;
    }
}
