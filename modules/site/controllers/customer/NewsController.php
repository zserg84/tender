<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:18
 */

namespace modules\site\controllers\customer;


class NewsController extends \modules\site\controllers\frontend\NewsController
{

    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 