<?php

namespace modules\contract\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use modules\themes\Module as ThemeModule;

/**
 * This is the model class for table "contract_comment".
 *
 * @property integer $id
 * @property integer $contract_id
 * @property integer $self_contract_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $text
 * @property integer $estimate
 * @property integer $parent_id
 *
 * @property Contract $contract
 * @property Contract $selfContract
 */
class ContractComment extends \yii\db\ActiveRecord
{
    const ESTIMATE_NEGATIVE = -1;
    const ESTIMATE_NEUTRAL = 0;
    const ESTIMATE_POSITIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id', 'self_contract_id'], 'required'],
            [['contract_id', 'self_contract_id', 'estimate'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('contract_comment', 'ID'),
            'contract_id' => Yii::t('contract_comment', 'Contract ID'),
            'self_contract_id' => Yii::t('contract_comment', 'Comment Contract ID'),
            'created_at' => Yii::t('contract_comment', 'created_at'),
            'text' => Yii::t('contract_comment', 'Text'),
            'estimate' => Yii::t('contract_comment', 'Estimate'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelfContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'self_contract_id']);
    }

    public static  function estimateList(){
        return [
            self::ESTIMATE_POSITIVE => ThemeModule::t('ALL_INTERFACES', 'COMMENT_POSITIVE'),
            self::ESTIMATE_NEUTRAL => ThemeModule::t('ALL_INTERFACES', 'COMMENT_NEUTRAL'),
            self::ESTIMATE_NEGATIVE => ThemeModule::t('ALL_INTERFACES', 'COMMENT_NEGATIVE'),
        ];
    }

    public static function getEstimateText($estimate){
        $list = self::estimateList();
        return isset($list[$estimate]) ? $list[$estimate] : $list[self::ESTIMATE_NEUTRAL];
    }

    public static function estimateClasses(){
        return [
            self::ESTIMATE_POSITIVE => 'green',
            self::ESTIMATE_NEUTRAL => 'gray',
            self::ESTIMATE_NEGATIVE => 'red',
        ];
    }

    public static function getEstimateClass($estimate){
        $list = self::estimateClasses();
        return isset($list[$estimate]) ? $list[$estimate] : $list[self::ESTIMATE_NEUTRAL];
    }
}
