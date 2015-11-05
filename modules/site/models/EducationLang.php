<?php

namespace modules\site\models;

use modules\site\models\query\EducationLangQuery;
use Yii;

/**
 * This is the model class for table "education_lang".
 *
 * @property integer $id
 * @property integer $education_id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Lang $lang
 * @property Education $education
 */
class EducationLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['education_id', 'lang_id', 'title'], 'required'],
            [['education_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
//            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
//            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::className(), 'targetAttribute' => ['education_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'education_id' => 'Education ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
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
     * @return EducationLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EducationLangQuery(get_called_class());
    }
}
