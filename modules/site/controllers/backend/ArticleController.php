<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:29
 */

namespace modules\site\controllers\backend;



use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\components\BackendController;
use modules\lang\models\Lang;
use modules\site\models\Article;
use modules\site\models\ArticleLang;
use modules\site\models\backend\form\ArticleForm;
use modules\site\models\backend\search\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ArticleController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ArticleSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Article::className(),
                'formModelClass' => ArticleForm::className(),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Article::className(),
                'formModelClass' => ArticleForm::className(),
                'beforeAction' => function($action, $model, $formModel){
                    $languages = Lang::find()->all();
                    $itemLangs = $model->articleLangs;
                    $itemLangs = ArrayHelper::index($itemLangs, 'lang_id');
                    foreach($languages as $language){
                        $itemLang = isset($itemLangs[$language->id]) ? $itemLangs[$language->id] : new ArticleLang();
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
                'modelClass' => Article::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Article::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
        ];
    }

    public function afterEdit($action, $model, $formModel)
    {
        $model->saveLangsRelations('articleLangs', $formModel, 'translationTitle', 'title', 'article_id');
        $model->saveLangsRelations('articleLangs', $formModel, 'translationText', 'text', 'article_id');

        return $model;
    }
} 