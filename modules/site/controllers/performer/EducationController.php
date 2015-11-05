<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:26
 */

namespace modules\site\controllers\performer;


class EducationController extends \modules\site\controllers\frontend\EducationController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 