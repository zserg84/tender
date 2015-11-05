<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:48
 */

namespace modules\site\controllers\customer;


class ContactController extends \modules\site\controllers\frontend\ContactController
{
    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 