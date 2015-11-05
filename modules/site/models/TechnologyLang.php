<?php

namespace modules\site\models;

use modules\lang\models\Lang;
use Yii;

/**
 * This is the model class for table "technology_lang".
 *
 * @property integer $id
 * @property integer $technology_id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Lang $lang
 * @property Technology $technology
 */
class TechnologyLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technology_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['technology_id', 'lang_id'], 'required'],
            [['technology_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
//            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
//            [['technology_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technology::className(), 'targetAttribute' => ['technology_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'technology_id' => 'Technology ID',
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
    public function getTechnology()
    {
        return $this->hasOne(Technology::className(), ['id' => 'technology_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\TechnologyLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\TechnologyLangQuery(get_called_class());
    }
}
