<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:27
 */

namespace modules\site\controllers\customer;

class EducationController extends \modules\site\controllers\frontend\EducationController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 