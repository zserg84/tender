<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $created_at
 *
 * @property NewsLang[] $newsLangs
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
    public function getNewsLangs()
    {
        return $this->hasMany(NewsLang::className(), ['news_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\site\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\NewsQuery(get_called_class());
    }
}
