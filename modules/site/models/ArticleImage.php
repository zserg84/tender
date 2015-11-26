<?php

namespace modules\site\models;

use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "article_image".
 *
 * @property integer $article_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property Article $article
 */
class ArticleImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'image_id'], 'required'],
            [['article_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
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
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\ArticleImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\ArticleImageQuery(get_called_class());
    }
}
