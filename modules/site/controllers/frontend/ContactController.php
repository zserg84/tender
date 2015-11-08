<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:47
 */

namespace modules\site\controllers\frontend;


use modules\site\components\Controller;

class ContactController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
} 