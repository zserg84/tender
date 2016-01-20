<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 14:08
 */

namespace modules\site\controllers\frontend;


use modules\lang\models\Lang;
use yii\web\Controller;
use modules\site\models\News;
use modules\site\models\NewsLang;
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

    public function actionGetModalInfo($id){
        $model = News::findOne($id);
        $lang = Lang::getCurrent();
        $modelLang = NewsLang::findOne([
            'news_id' => $model->id,
            'lang_id' => $lang->id
        ]);
        if($modelLang)
            return $this->renderAjax('modal-info', [
                'model' => $model,
                'modelLang' => $modelLang,
            ]);
    }
} 