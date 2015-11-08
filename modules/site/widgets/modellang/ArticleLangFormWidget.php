<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 12:09
 */

namespace modules\site\widgets\modellang;


use yii\base\InvalidConfigException;
use yii\base\Widget;

class ArticleLangFormWidget extends Widget
{
    public $articleModel;

    public function init()
    {
        parent::init();

        if ($this->articleModel === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
    }

    public function run()
    {
        return \Yii::$app->controller->run('/site/article/lang-form', [
            'articleId' => $this->articleModel->id,
        ]);
    }
} 