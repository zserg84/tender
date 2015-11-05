<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 14:00
 */

namespace modules\site\controllers\frontend;

use modules\lang\models\Lang;
use modules\site\components\Controller;
use modules\site\models\AboutLang;

class AboutController extends Controller
{

    public function actionIndex(){
        $langId = Lang::getCurrent()->id;
        $model = AboutLang::findOne([
            'lang_id' => $langId
        ]);
        return $this->render('index', [
            'model' => $model,
        ]);
    }
} 