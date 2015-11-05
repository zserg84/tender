<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 14:08
 */

namespace modules\site\controllers\frontend;


use modules\site\components\Controller;
use modules\site\models\News;
use yii\data\ActiveDataProvider;

class NewsController extends Controller
{

    public function actionIndex(){
        $query = News::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
} 