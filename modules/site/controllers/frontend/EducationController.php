<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:25
 */

namespace modules\site\controllers\frontend;


use modules\lang\models\Lang;
use modules\site\components\Controller;
use modules\site\models\Education;
use modules\site\models\EducationLang;
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

    public function actionGetModalInfo($id){
        $model = Education::findOne($id);
        $lang = Lang::getCurrent();
        $modelLang = EducationLang::findOne([
            'education_id' => $model->id,
            'lang_id' => $lang->id
        ]);
        if($modelLang)
            return $this->renderAjax('modal-info', [
                'model' => $model,
                'modelLang' => $modelLang,
            ]);
    }
} 