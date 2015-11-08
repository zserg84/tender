<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 22:12
 */

namespace modules\site\widgets\modellang;

use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;

class NewsLangFormWidget extends Widget
{
    public $newsModel;

    public function init()
    {
        parent::init();

        if ($this->newsModel === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
    }

    public function run()
    {
        return \Yii::$app->controller->run('/site/news/lang-form', [
            'newsId' => $this->newsModel->id,
        ]);
    }
} 