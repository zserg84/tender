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
use modules\image\models\Image;
use modules\lang\models\Lang;
use modules\site\models\backend\form\NewsForm;
use modules\site\models\backend\form\NewsLangForm;
use modules\site\models\backend\search\NewsSearch;
use modules\site\models\News;
use modules\site\models\NewsImage;
use modules\site\models\NewsLang;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

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
                    return $this->afterEdit($model, $formModel);
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
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }

    public function afterEdit($model, $formModel)
    {
        $images = UploadedFile::getInstances($formModel, 'images');
        foreach($images as $image){
            $formModel->dop_image = $image;
            if ($imageModel = $formModel->getImageModel('dop_image')) {
                $ni = NewsImage::find()->where([
                    'image_id' => $imageModel->id,
                    'news_id' => $model->id,
                ])->one();
                $ni = $ni ? $ni : new NewsImage();
                $ni->image_id = $imageModel->id;
                $ni->news_id = $model->id;
                $ni->save();
            }
        }

        $modelLang = NewsLang::findOne([
            'news_id' => $model->id,
            'lang_id' => $model->original_language_id
        ]);

        $modelLang = $modelLang ? $modelLang : new NewsLang();
        $modelLang->news_id = $model->id;
        $modelLang->lang_id = $model->original_language_id;
        $modelLang->title = $formModel->title;
        $modelLang->text = $formModel->text;
        $modelLang->save();

        return $model;
    }

    public function actionUpdate($id){
        $model = News::findOne($id);
        $formModel = new NewsForm();
        $formModel->setAttributes($model->attributes);

        $formModel->images = $model->newsImages;

        $modelLang = $model->getNewsLangs()->andWhere([
            'lang_id' => $model->original_language_id
        ])->one();
        $modelLang = $modelLang ? $modelLang : new NewsLang();
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
                    return $this->redirect(Url::toRoute(['/site/news/index']));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'formModel' => $formModel,
        ]);
    }

    public function actionLangForm($newsId){
        $langId = \Yii::$app->getRequest()->get('langId');

        $formModel = new NewsLangForm();
        $newsModel = News::findOne($newsId);
        $query = NewsLang::find()->andWhere([
            'news_id' => $newsId,
        ])->andWhere([
            '<>', 'lang_id', $newsModel->original_language_id
        ]);
        if($langId) {
            $query->andWhere(['lang_id' => $langId]);
        }
        $model = $query->one();

        $model = $model ? $model : new NewsLang();

        $formModel->setAttributes($model->attributes);
        $formModel->news_id = $newsId;
        $formModel->lang_id = $formModel->lang_id ? $formModel->lang_id : $langId;

        if($formModel->load(\Yii::$app->getRequest()->post())){
            if (\Yii::$app->getRequest()->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($formModel);
            }
            if($formModel->validate()){
                $model = NewsLang::find()->andWhere([
                    'news_id' => $newsId,
                    'lang_id' => $formModel->lang_id
                ])->one();
                $model = $model ? $model : new NewsLang();
                $model->setAttributes($formModel->attributes);
                if($model->save()){
                    return $this->redirect(Url::toRoute(['/site/news/update', 'id'=>$model->news_id]));
                }
            }
        }

        if(\Yii::$app->getRequest()->isPjax)
            return $this->renderPartial('_lang_form', [
                'model' => $model,
                'formModel' => $formModel,
                'newsModel' => $newsModel,
            ]);
        else
            return $this->renderPartial('lang_update', [
                'model' => $model,
                'formModel' => $formModel,
                'newsModel' => $newsModel,
            ]);
    }
} 