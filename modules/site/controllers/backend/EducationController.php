<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:45
 */

namespace modules\site\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\components\BackendController;
use modules\lang\models\Lang;
use modules\site\models\backend\form\EducationForm;
use modules\site\models\backend\form\EducationLangForm;
use modules\site\models\backend\search\EducationSearch;
use modules\site\models\Education;
use modules\site\models\EducationLang;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

class EducationController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => EducationSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Education::className(),
                'formModelClass' => EducationForm::className(),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Education::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Education::className(),
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

        $modelLang = EducationLang::findOne([
            'education_id' => $model->id,
            'lang_id' => $model->original_language_id
        ]);

        $modelLang = $modelLang ? $modelLang : new EducationLang();
        $modelLang->education_id = $model->id;
        $modelLang->lang_id = $model->original_language_id;
        $modelLang->title = $formModel->title;
        $modelLang->text = $formModel->text;
        $modelLang->save();

        return $model;
    }

    public function actionUpdate($id){
        $model = Education::findOne($id);
        $formModel = new EducationForm();
        $formModel->setAttributes($model->attributes);
        $formModel->image = $model->image;

        $modelLang = $model->getEducationLangs()->andWhere([
            'lang_id' => $model->original_language_id
        ])->one();
        $modelLang = $modelLang ? $modelLang : new EducationLang();
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
                    return $this->redirect(Url::toRoute(['/site/education/index']));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'formModel' => $formModel,
        ]);
    }

    public function actionLangForm($educationId){
        $langId = \Yii::$app->getRequest()->get('langId');

        $formModel = new EducationLangForm();
        $educationModel = Education::findOne($educationId);
        $query = EducationLang::find()->andWhere([
            'education_id' => $educationId,
        ])->andWhere([
            '<>', 'lang_id', $educationModel->original_language_id
        ]);
        if($langId) {
            $query->andWhere(['lang_id' => $langId]);
        }
        $model = $query->one();

        $model = $model ? $model : new EducationLang();

        $formModel->setAttributes($model->attributes);
        $formModel->education_id = $educationId;
        $formModel->lang_id = $formModel->lang_id ? $formModel->lang_id : $langId;

        if($formModel->load(\Yii::$app->getRequest()->post())){
            if (\Yii::$app->getRequest()->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($formModel);
            }
            if($formModel->validate()){
                $model = EducationLang::find()->andWhere([
                    'education_id' => $educationId,
                    'lang_id' => $formModel->lang_id
                ])->one();
                $model = $model ? $model : new EducationLang();
                $model->setAttributes($formModel->attributes);
                if($model->save()){
                    return $this->redirect(Url::toRoute(['/site/education/update', 'id'=>$model->education_id]));
                }
            }
        }

        if(\Yii::$app->getRequest()->isPjax)
            return $this->renderPartial('_lang_form', [
                'model' => $model,
                'formModel' => $formModel,
                'educationModel' => $educationModel,
            ]);
        else
            return $this->renderPartial('lang_update', [
                'model' => $model,
                'formModel' => $formModel,
                'educationModel' => $educationModel,
            ]);
    }
} 