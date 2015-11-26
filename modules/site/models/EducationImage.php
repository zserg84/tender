<?php

namespace modules\site\models;

use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "education_image".
 *
 * @property integer $education_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property Education $education
 */
class EducationImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['education_id', 'image_id'], 'required'],
            [['education_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::className(), 'targetAttribute' => ['education_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'education_id' => 'Education ID',
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
    public function getEducation()
    {
        return $this->hasOne(Education::className(), ['id' => 'education_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\EducationImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\EducationImageQuery(get_called_class());
    }
}
