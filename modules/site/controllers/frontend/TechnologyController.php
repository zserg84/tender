<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:28
 */

namespace modules\site\controllers\frontend;


use modules\direction\models\Direction;
use modules\lang\models\Lang;
use yii\web\Controller;
use modules\site\models\Technology;
use modules\site\models\TechnologyLang;
use yii\base\Exception;
use yii\data\ActiveDataProvider;

class TechnologyController extends Controller
{

    public function actionIndex($directionId){
        $direction = Direction::findOne($directionId);
        if(!$direction)
            throw new Exception('Unknown direction');

        $query = Technology::find()->where([
            'direction_id' => $directionId
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'direction' => $direction,
        ]);
    }

    public function actionGetModalInfo($id){
        $model = Technology::findOne($id);
        $lang = Lang::getCurrent();
        $modelLang = TechnologyLang::findOne([
            'technology_id' => $model->id,
            'lang_id' => $lang->id
        ]);
        if($modelLang)
            return $this->renderAjax('modal-info', [
                'model' => $model,
                'modelLang' => $modelLang,
            ]);
    }
} 