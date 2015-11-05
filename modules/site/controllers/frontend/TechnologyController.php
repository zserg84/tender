<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:28
 */

namespace modules\site\controllers\frontend;


use modules\direction\models\Direction;
use modules\site\components\Controller;
use modules\site\models\Technology;
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
} 