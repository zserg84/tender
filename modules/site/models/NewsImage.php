<?php

namespace modules\site\models;

use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "news_image".
 *
 * @property integer $news_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property News $news
 */
class NewsImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'image_id'], 'required'],
            [['news_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
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
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\NewsImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\NewsImageQuery(get_called_class());
    }
}
