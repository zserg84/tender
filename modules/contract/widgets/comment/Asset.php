<?php

namespace modules\contract\widgets\comment;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@modules/contract/widgets/comment/assets/';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/comments.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];
}
