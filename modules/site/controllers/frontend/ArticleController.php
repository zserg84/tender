<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:23
 */

namespace modules\site\controllers\frontend;


use modules\site\components\Controller;
use modules\site\models\Article;
use yii\data\ActiveDataProvider;

class ArticleController extends Controller
{

    public function actionIndex(){
        $query = Article::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
} 