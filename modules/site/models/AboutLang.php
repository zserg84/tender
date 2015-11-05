<?php

namespace modules\site\models;

use modules\lang\models\Lang;
use Yii;

/**
 * This is the model class for table "about_lang".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Lang $lang
 */
class AboutLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'about_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'title'], 'required'],
            [['lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['lang_id'], 'unique', 'targetAttribute' => ['lang_id'], 'message' => 'The Lang has already been taken.'],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
     * @inheritdoc
     * @return \modules\site\models\query\AboutLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\AboutLangQuery(get_called_class());
    }
}
