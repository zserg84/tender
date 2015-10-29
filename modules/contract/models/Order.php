<?php

namespace modules\contract\models;

use modules\direction\models\Direction;
use modules\image\models\Image;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $contract_id
 * @property string $short_description
 * @property string $description
 * @property string $created_at
 * @property string $date_performance
 * @property string $date_publish
 * @property string $material
 * @property integer $count
 * @property integer $budget
 * @property integer $material_belongs_customer
 * @property integer $material_included_budget
 * @property integer $has_modeling
 * @property integer $status
 * @property string $file_model_id
 * @property string $image_id
 * @property integer $currency_id
 *
 * @property ContractOrder[] $contractOrders
 * @property OfferToCustomer[] $offerToCustomers
 * @property OfferToPerformer[] $offerToPerformers
 * @property Contract $contract
 * @property Currency $currency
 * @property OrderComment[] $orderComments
 * @property OrderHasDirection[] $orderHasDirections
 * @property Direction[] $directions
 * @property OrderPerformer[] $orderPerformers
 */
class Order extends \yii\db\ActiveRecord
{

    const DEFAULT_COVER_SRC = '';

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id'], 'required'],
            [['id', 'contract_id', 'count', 'budget', 'material_belongs_customer', 'material_included_budget', 'has_modeling', 'status', 'currency_id', 'file_model_id', 'image_id', 'created_at'], 'integer'],
            [['short_description'], 'string'],
            [['date_performance', 'date_publish'], 'safe'],
            [['description', 'material'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehaviorCreatedAt' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            /*'timestampBehaviorPerformance' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_performance',
                'updatedAtAttribute' => false,
            ],
            'timestampBehaviorPublish' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_publish',
                'updatedAtAttribute' => false,
            ]*/
        ];
    }

    public function beforeSave($insert){
        $this->date_performance = Yii::$app->getFormatter()->asTimestamp($this->date_performance);
        $this->date_publish = Yii::$app->getFormatter()->asTimestamp($this->date_publish);
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractOrders()
    {
        return $this->hasMany(ContractOrder::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferToCustomers()
    {
        return $this->hasMany(OfferToCustomer::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferToPerformers()
    {
        return $this->hasMany(OfferToPerformer::className(), ['order_id' => 'id']);
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
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderComments()
    {
        return $this->hasMany(OrderComment::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasDirections()
    {
        return $this->hasMany(OrderHasDirection::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirections()
    {
        return $this->hasMany(Direction::className(), ['id' => 'direction_id'])->viaTable('order_has_direction', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderPerformers()
    {
        return $this->hasMany(OrderPerformer::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    public function getLogo($w=null) {
        if ($this->image_id) {
            return $this->image->getSrc($w);
        }
        return self::DEFAULT_COVER_SRC;
    }

    public function saveLogo() {
        if (is_null($this->image)) return;
        if (($tmpName = $this->image->tempName) and ($ext = $this->image->extension)) {
            if ($image = Image::GetByFile($tmpName, $ext)) {
                $this->image_id = $image->id;
                $this->save();
            }
        }
    }

    public function saveFileModel() {
        if (is_null($this->image)) return;
        if (($tmpName = $this->image->tempName) and ($ext = $this->image->extension)) {
            if ($image = Image::GetByFile($tmpName, $ext)) {
                $this->file_model_id = $image->id;
                $this->save();
            }
        }
    }
}
