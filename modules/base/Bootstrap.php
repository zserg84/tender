<?php

namespace modules\base;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Base bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::$app->set('base',
            [
                'class' => 'modules\base\components\Base'
            ]
        );
    }
}
