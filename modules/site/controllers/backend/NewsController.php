<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 11:19
 */

namespace modules\site\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\components\BackendController;
use modules\lang\models\Lang;
use modules\site\models\backend\form\NewsForm;
use modules\site\models\backend\search\NewsSearch;
use modules\site\models\News;
use modules\site\models\NewsLang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\HttpException;

class NewsController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => NewsSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => News::className(),
                'formModelClass' => NewsForm::className(),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => News::className(),
                'formModelClass' => NewsForm::className(),
                'beforeAction' => function($action, $model, $formModel){
                    $languages = Lang::find()->all();
                    $itemLangs = $model->newsLangs;
                    $itemLangs = ArrayHelper::index($itemLangs, 'lang_id');
                    foreach($languages as $language){
                        $itemLang = isset($itemLangs[$language->id]) ? $itemLangs[$language->id] : new NewsLang();
                        $formModel->translationTitle[$language->id] = $itemLang->title;
                        $formModel->translationText[$language->id] = $itemLang->text;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => News::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => News::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
        ];
    }

    public function afterEdit($action, $model, $formModel)
    {
        $model->saveLangsRelations('newsLangs', $formModel, 'translationTitle', 'title', 'news_id');
        $model->saveLangsRelations('newsLangs', $formModel, 'translationText', 'text', 'news_id');

        return $model;
    }
} 