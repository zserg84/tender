<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:30
 */

namespace modules\site\controllers\performer;


class TechnologyController extends \modules\site\controllers\frontend\TechnologyController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 