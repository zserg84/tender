<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:25
 */

namespace modules\site\controllers\frontend;


use modules\site\components\Controller;
use modules\site\models\Education;
use yii\data\ActiveDataProvider;

class EducationController extends Controller
{
    public function actionIndex(){
        $query = Education::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
} 