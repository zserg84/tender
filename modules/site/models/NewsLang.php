<?php

namespace modules\site\models;

use modules\lang\models\Lang;
use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Lang $lang
 * @property News $news
 */
class NewsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['news_id', 'lang_id', 'title'], 'required'],
            [['news_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
//            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
//            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
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
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\NewsLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\NewsLangQuery(get_called_class());
    }
}
