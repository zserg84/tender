<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\lang\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $original_language_id
 * @property string $date
 * @property string $video_url
 *
 * @property Lang $originalLanguage
 * @property ArticleImage[] $articleImages
 * @property Image[] $images
 * @property ArticleLang[] $articleLangs
 * @property Lang[] $langs
 */
class Article extends \yii\db\ActiveRecord
{
    public $title;
    public $text;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'original_language_id'], 'integer'],
            [['date'], 'safe'],
            [['video_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'original_language_id' => 'Original Language ID',
            'date' => 'Date',
            'video_url' => 'Video Url',
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            /*'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ArticleLang::className(),
                'relationFieldName' => 'article_id',
                'translateFieldNames' => ['title', 'text'],
            ],*/
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOriginalLanguage()
    {
        return $this->hasOne(Lang::className(), ['id' => 'original_language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleImages()
    {
        return $this->hasMany(ArticleImage::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('article_image', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleLangs()
    {
        return $this->hasMany(ArticleLang::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('article_lang', ['article_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\ArticleQuery(get_called_class());
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->date = $this->date ? Yii::$app->getFormatter()->asTimestamp($this->date) : null;
            $this->date = $this->date ? date('Y-m-d', $this->date) : date('Y-m-d');
            return true;
        }
        return false;
    }

    public function afterFind(){
        parent::afterFind();
        $this->date = $this->date ? Yii::$app->getFormatter()->asDate($this->date) : null;
    }
}
