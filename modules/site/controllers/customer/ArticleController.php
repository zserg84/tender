<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 10:25
 */

namespace modules\site\controllers\customer;


class ArticleController extends \modules\site\controllers\frontend\ArticleController
{
    public function init(){
        $this->module->setViewPath($this->setViewPath('@modules/site/views/frontend'));
    }

} 