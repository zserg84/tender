<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:48
 */

namespace modules\site\controllers\customer;


class PartnerController extends \modules\site\controllers\frontend\PartnerController
{
    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }
} 