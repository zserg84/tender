<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 23:03
 */

namespace modules\base\behaviors;

use modules\image\models\Image;
use yii\base\Behavior;

class ImageBehavior extends Behavior
{

    public function getImage($fieldName) {
        $owner = $this->owner;
        if (!isset($owner->$fieldName) || is_null($owner->$fieldName)) return;
        if (($tmpName = $owner->$fieldName->tempName) and ($ext = $owner->$fieldName->extension)) {
            if ($image = Image::GetByFile($tmpName, $ext)) {
                return $image;
            }
        }
    }

    /*
     * getImage - Название рилейшна во многих моделях.
     * getImageModel - метод-обертка, чтобы можно было вызывать getImage() в таких моделях/
     * */
    public function getImageModel($fieldName) {
        return $this->getImage($fieldName);
    }
} 