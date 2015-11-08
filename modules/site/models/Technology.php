<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\direction\models\Direction;
use modules\image\models\Image;
use modules\lang\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "technology".
 *
 * @property integer $id
 * @property integer $direction_id
 * @property integer $created_at
 * @property integer $original_language_id
 * @property string $date
 * @property integer $image_id
 * @property string $video_url
 *
 * @property Direction $direction
 * @property TechnologyLang[] $technologyLangs
 * @property Image $image
 * @property Lang $originalLanguage
 * @property Lang[] $langs
 */
class Technology extends \yii\db\ActiveRecord
{
    public $title;
    public $text;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technology';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id'], 'required'],
            [['direction_id', 'created_at', 'original_language_id', 'image_id'], 'integer'],
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
            'direction_id' => 'Direction ID',
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => TechnologyLang::className(),
                'relationFieldName' => 'technology_id',
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
    public function getDirection()
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechnologyLangs()
    {
        return $this->hasMany(TechnologyLang::className(), ['technology_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('technology_lang', ['technology_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\TechnologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\TechnologyQuery(get_called_class());
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
