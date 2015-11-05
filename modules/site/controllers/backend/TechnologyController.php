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
use modules\site\models\backend\search\TechnologySearch;
use modules\site\models\Technology;
use modules\site\models\TechnologyLang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
                    return $this->afterEdit($action, $model, $formModel);
                },
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Technology::className(),
                'formModelClass' => TechnologyForm::className(),
                'beforeAction' => function($action, $model, $formModel){
                    $languages = Lang::find()->all();
                    $itemLangs = $model->technologyLangs;
                    $itemLangs = ArrayHelper::index($itemLangs, 'lang_id');
                    foreach($languages as $language){
                        $itemLang = isset($itemLangs[$language->id]) ? $itemLangs[$language->id] : new TechnologyLang();
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

    public function afterEdit($action, $model, $formModel)
    {
        $model->saveLangsRelations('technologyLangs', $formModel, 'translationTitle', 'title', 'technology_id');
        $model->saveLangsRelations('technologyLangs', $formModel, 'translationText', 'text', 'technology_id');

        return $model;
    }
} 