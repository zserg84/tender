<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\lang\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "education".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $original_language_id
 * @property string $date
 * @property integer $image_id
 * @property string $video_url
 *
 * @property Image $image
 * @property Lang $originalLanguage
 * @property EducationLang[] $educationLangs
 * @property Lang[] $langs
 */
class Education extends \yii\db\ActiveRecord
{
    public $title;
    public $text;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'original_language_id', 'image_id'], 'integer'],
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
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => EducationLang::className(),
                'relationFieldName' => 'education_id',
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
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
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
    public function getEducationLangs()
    {
        return $this->hasMany(EducationLang::className(), ['education_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('education_lang', ['education_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\EducationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\EducationQuery(get_called_class());
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
