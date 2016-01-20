<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:23
 */

namespace modules\site\controllers\frontend;


use modules\lang\models\Lang;
use yii\web\Controller;
use modules\site\models\Article;
use modules\site\models\ArticleLang;
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

    public function actionGetModalInfo($id){
        $model = Article::findOne($id);
        $lang = Lang::getCurrent();
        $modelLang = ArticleLang::findOne([
            'article_id' => $model->id,
            'lang_id' => $lang->id
        ]);
        if($modelLang)
            return $this->renderAjax('modal-info', [
                'model' => $model,
                'modelLang' => $modelLang,
            ]);
    }
} 