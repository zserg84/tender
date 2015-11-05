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
use modules\site\models\backend\search\EducationSearch;
use modules\site\models\Education;
use modules\site\models\EducationLang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
                    return $this->afterEdit($action, $model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Education::className(),
                'formModelClass' => EducationForm::className(),
                'beforeAction' => function($action, $model, $formModel){
                    $languages = Lang::find()->all();
                    $itemLangs = $model->educationLangs;
                    $itemLangs = ArrayHelper::index($itemLangs, 'lang_id');
                    foreach($languages as $language){
                        $itemLang = isset($itemLangs[$language->id]) ? $itemLangs[$language->id] : new EducationLang();
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

    public function afterEdit($action, $model, $formModel)
    {
        $model->saveLangsRelations('educationLangs', $formModel, 'translationTitle', 'title', 'education_id');
        $model->saveLangsRelations('educationLangs', $formModel, 'translationText', 'text', 'education_id');

        return $model;
    }
} 