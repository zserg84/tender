<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "education".
 *
 * @property integer $id
 * @property integer $created_at
 *
 * @property EducationLang[] $educationLangs
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
            [['created_at'], 'integer'],
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
    public function getEducationLangs()
    {
        return $this->hasMany(EducationLang::className(), ['education_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\EducationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\EducationQuery(get_called_class());
    }
}
