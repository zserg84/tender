<?php

namespace modules\site\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\components\BackendController;
use modules\lang\models\backend\LangSearch;
use modules\lang\models\Lang;
use modules\site\models\AboutLang;
use modules\site\models\backend\search\AboutSearch;
use yii\filters\VerbFilter;
use vova07\admin\components\Controller;
use yii\helpers\Url;
use yii\web\HttpException;

class AboutController extends BackendController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => AboutSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => AboutLang::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => AboutLang::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => AboutLang::className(),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => AboutLang::className(),
            ],
        ];
    }

    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = AboutLang::findAll($id);
        } else {
            $model = AboutLang::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
}
