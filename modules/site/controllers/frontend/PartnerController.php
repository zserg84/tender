<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:47
 */

namespace modules\site\controllers\frontend;


use modules\site\components\Controller;

class PartnerController extends Controller
{

    public function index(){
        return $this->render('index');
    }
} 