<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\lang\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $created_at
 *
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
                'translateModelName' => ArticleLang::className(),
                'relationFieldName' => 'article_id',
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
    public function getArticleLangs()
    {
        return $this->hasMany(ArticleLang::className(), ['article_id' => 'id'])->indexBy('lang_id');
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
}
