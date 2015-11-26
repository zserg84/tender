<?php

namespace modules\site\models;

use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "technology_image".
 *
 * @property integer $technology_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property Technology $technology
 */
class TechnologyImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technology_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['technology_id', 'image_id'], 'required'],
            [['technology_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['technology_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technology::className(), 'targetAttribute' => ['technology_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'technology_id' => 'Technology ID',
            'image_id' => 'Image ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechnology()
    {
        return $this->hasOne(Technology::className(), ['id' => 'technology_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\TechnologyImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\TechnologyImageQuery(get_called_class());
    }
}
