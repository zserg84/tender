<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\lang\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $original_language_id
 * @property string $date
 * @property string $source
 * @property string $video_url
 * @property string $lit
 * @property string $source_image
 *
 * @property Lang $originalLanguage
 * @property NewsImage[] $newsImages
 * @property Image[] $images
 * @property NewsLang[] $newsLangs
 * @property Lang[] $langs
 */
class News extends \yii\db\ActiveRecord
{
    public $title;
    public $text;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'original_language_id'], 'integer'],
            [['date'], 'safe'],
            [['source', 'video_url', 'lit', 'source_image'], 'string', 'max' => 255],
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
            'source' => 'Source',
            'video_url' => 'Video Url',
            'lit' => 'Lit',
            'source_image' => 'Source Image',
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => NewsLang::className(),
                'relationFieldName' => 'news_id',
                'translateFieldNames' => ['title', 'text'],
            ],
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
    public function getNewsImages()
    {
        return $this->hasMany(NewsImage::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('news_image', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsLangs()
    {
        return $this->hasMany(NewsLang::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('news_lang', ['news_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\NewsQuery(get_called_class());
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
