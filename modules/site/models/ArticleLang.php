<?php

namespace modules\site\models;

use modules\lang\models\Lang;
use Yii;

/**
 * This is the model class for table "article_lang".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Lang $lang
 * @property Article $article
 */
class ArticleLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['article_id', 'lang_id', 'title'], 'required'],
            [['article_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['lang_id', 'article_id'], 'unique', 'targetAttribute' => ['lang_id', 'article_id'], 'message' => 'The combination of Article ID and Lang ID has already been taken.'],
//            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
//            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
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
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\ArticleLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\ArticleLangQuery(get_called_class());
    }
}
