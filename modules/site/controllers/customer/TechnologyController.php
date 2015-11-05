<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:31
 */

namespace modules\site\controllers\customer;


class TechnologyController extends \modules\site\controllers\frontend\TechnologyController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 