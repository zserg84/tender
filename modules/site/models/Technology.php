<?php

namespace modules\site\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\direction\models\Direction;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "technology".
 *
 * @property integer $id
 * @property integer $direction_id
 * @property integer $created_at
 *
 * @property Direction $direction
 * @property TechnologyLang[] $technologyLangs
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
            [['direction_id', 'created_at'], 'integer'],
//            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::className(), 'targetAttribute' => ['direction_id' => 'id']],
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
     * @inheritdoc
     * @return \modules\site\models\query\TechnologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\site\models\query\TechnologyQuery(get_called_class());
    }
}
