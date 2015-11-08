<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 15:32
 */

namespace modules\site\widgets\modellang;


use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;

class TechnologyLangFormWidget extends Widget
{
    public $technologyModel;

    public function init()
    {
        parent::init();

        if ($this->technologyModel === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
    }

    public function run()
    {
        return \Yii::$app->controller->run('/site/technology/lang-form', [
            'technologyId' => $this->technologyModel->id,
        ]);
    }

} 