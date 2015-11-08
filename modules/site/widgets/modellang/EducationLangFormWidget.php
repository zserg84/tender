<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 08.11.15
 * Time: 13:00
 */

namespace modules\site\widgets\modellang;


use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;

class EducationLangFormWidget extends Widget
{

    public $educationModel;

    public function init()
    {
        parent::init();

        if ($this->educationModel === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
    }

    public function run()
    {
        return \Yii::$app->controller->run('/site/education/lang-form', [
            'educationId' => $this->educationModel->id,
        ]);
    }
} 