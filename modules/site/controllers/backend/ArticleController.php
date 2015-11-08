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
use modules\site\models\backend\form\ArticleLangForm;
use modules\site\models\backend\search\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

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
                    return $this->afterEdit($model, $formModel);
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

    public function afterEdit($model, $formModel)
    {
        $formModel->image = UploadedFile::getInstance($formModel, 'image');
        if ($image = $formModel->getImageModel('image')) {
            $model->image_id = $image->id;
            $model->save();
        }

        $modelLang = ArticleLang::findOne([
            'article_id' => $model->id,
            'lang_id' => $model->original_language_id
        ]);

        $modelLang = $modelLang ? $modelLang : new ArticleLang();
        $modelLang->article_id = $model->id;
        $modelLang->lang_id = $model->original_language_id;
        $modelLang->title = $formModel->title;
        $modelLang->text = $formModel->text;
        $modelLang->save();

        return $model;
    }

    public function actionUpdate($id){
        $model = Article::findOne($id);
        $formModel = new ArticleForm();
        $formModel->setAttributes($model->attributes);
        $formModel->image = $model->image;

        $modelLang = $model->getArticleLangs()->andWhere([
            'lang_id' => $model->original_language_id
        ])->one();
        $modelLang = $modelLang ? $modelLang : new ArticleLang();
        $formModel->title = $modelLang->title;
        $formModel->text = $modelLang->text;

        if($formModel->load(\Yii::$app->getRequest()->post())){
            if (\Yii::$app->getRequest()->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($formModel);
            }
            if($formModel->validate()){
                $model->setAttributes($formModel->attributes);
                if($model->save()){
                    $this->afterEdit($model, $formModel);
                    return $this->redirect(Url::toRoute(['/site/article/index']));
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
            'formModel' => $formModel,
        ]);
    }

    public function actionLangForm($articleId){
        $langId = \Yii::$app->getRequest()->get('langId');

        $formModel = new ArticleLangForm();
        $articleModel = Article::findOne($articleId);
        $query = ArticleLang::find()->andWhere([
            'article_id' => $articleId,
        ])->andWhere([
            '<>', 'lang_id', $articleModel->original_language_id
        ]);
        if($langId) {
            $query->andWhere(['lang_id' => $langId]);
        }
        $model = $query->one();

        $model = $model ? $model : new ArticleLang();

        $formModel->setAttributes($model->attributes);
        $formModel->article_id = $articleId;
        $formModel->lang_id = $formModel->lang_id ? $formModel->lang_id : $langId;

        if($formModel->load(\Yii::$app->getRequest()->post())){
            if (\Yii::$app->getRequest()->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($formModel);
            }
            if($formModel->validate()){
                $model = ArticleLang::find()->andWhere([
                    'article_id' => $articleId,
                    'lang_id' => $formModel->lang_id
                ])->one();
                $model = $model ? $model : new ArticleLang();
                $model->setAttributes($formModel->attributes);
                if($model->save()){
                    return $this->redirect(Url::toRoute(['/site/article/update', 'id'=>$model->article_id]));
                }
            }
        }

        if(\Yii::$app->getRequest()->isPjax)
            return $this->renderPartial('_lang_form', [
                'model' => $model,
                'formModel' => $formModel,
                'articleModel' => $articleModel,
            ]);
        else
            return $this->renderPartial('lang_update', [
                'model' => $model,
                'formModel' => $formModel,
                'articleModel' => $articleModel,
            ]);
    }
} 