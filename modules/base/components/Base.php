<?php

namespace modules\base\components;

use Yii;
use yii\base\Component;

/**
 * Class System
 * @package modules\base\components
 * Base system component
 */
class Base extends Component
{
    /**
     * @var array Available extensions map
     */
    public $extensionsMap = [
        'users' => 'modules/users',
        'blogs' => 'modules/blog',
        'comments' => 'vova07/yii2-start-comments-module'
    ];

    /**
     * @param string $name Extension name
     *
     * @return boolean Whether extension is installed or not
     */
    public function hasExtension($name)
    {
        $extension = isset($this->extensionsMap[$name]) ? $this->extensionsMap[$name] : $name;

        return array_key_exists($extension, Yii::$app->extensions);
    }

    /**
     * @param string $str String to be encrypted
     *
     * @return int Encrypted string
     */
    public function crc32($str)
    {
        return sprintf("%u", crc32($str));
    }
}
