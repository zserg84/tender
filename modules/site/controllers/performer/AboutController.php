<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:16
 */

namespace modules\site\controllers\performer;

class AboutController extends \modules\site\controllers\frontend\AboutController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 