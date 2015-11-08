<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:15
 */

namespace modules\site\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\components\BackendController;
use modules\lang\models\Lang;
use modules\site\models\backend\form\TechnologyForm;
use modules\site\models\backend\form\TechnologyLangForm;
use modules\site\models\backend\search\TechnologySearch;
use modules\site\models\Technology;
use modules\site\models\TechnologyLang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class TechnologyController extends BackendController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => TechnologySearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Technology::className(),
                'formModelClass' => TechnologyForm::className(),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Technology::className(),
                'redirectUrl' => Url::toRoute(['index'])
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Technology::className(),
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

        $modelLang = TechnologyLang::findOne([
            'technology_id' => $model->id,
            'lang_id' => $model->original_language_id
        ]);

        $modelLang = $modelLang ? $modelLang : new TechnologyLang();
        $modelLang->technology_id = $model->id;
        $modelLang->lang_id = $model->original_language_id;
        $modelLang->title = $formModel->title;
        $modelLang->text = $formModel->text;
        $modelLang->save();

        return $model;

        return $model;
    }

    public function actionUpdate($id){
        $model = Technology::findOne($id);
        $formModel = new TechnologyForm();
        $formModel->setAttributes($model->attributes);
        $formModel->image = $model->image;

        $modelLang = $model->getTechnologyLangs()->andWhere([
            'lang_id' => $model->original_language_id
        ])->one();
        $modelLang = $modelLang ? $modelLang : new TechnologyLang();
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
                    return $this->redirect(Url::toRoute(['/site/technology/index']));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'formModel' => $formModel,
        ]);
    }

    public function actionLangForm($technologyId){
        $langId = \Yii::$app->getRequest()->get('langId');

        $formModel = new TechnologyLangForm();
        $technologyModel = Technology::findOne($technologyId);
        $query = TechnologyLang::find()->andWhere([
            'technology_id' => $technologyId,
        ])->andWhere([
            '<>', 'lang_id', $technologyModel->original_language_id
        ]);
        if($langId) {
            $query->andWhere(['lang_id' => $langId]);
        }
        $model = $query->one();

        $model = $model ? $model : new TechnologyLang();

        $formModel->setAttributes($model->attributes);
        $formModel->technology_id = $technologyId;
        $formModel->lang_id = $formModel->lang_id ? $formModel->lang_id : $langId;

        if($formModel->load(\Yii::$app->getRequest()->post())){
            if (\Yii::$app->getRequest()->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($formModel);
            }
            if($formModel->validate()){
                $model = TechnologyLang::find()->andWhere([
                    'technology_id' => $technologyId,
                    'lang_id' => $formModel->lang_id
                ])->one();
                $model = $model ? $model : new TechnologyLang();
                $model->setAttributes($formModel->attributes);
                if($model->save()){
                    return $this->redirect(Url::toRoute(['/site/technology/update', 'id'=>$model->technology_id]));
                }
            }
        }

        if(\Yii::$app->getRequest()->isPjax)
            return $this->renderPartial('_lang_form', [
                'model' => $model,
                'formModel' => $formModel,
                'technologyModel' => $technologyModel,
            ]);
        else
            return $this->renderPartial('lang_update', [
                'model' => $model,
                'formModel' => $formModel,
                'technologyModel' => $technologyModel,
            ]);
    }
} 