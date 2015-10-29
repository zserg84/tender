<?php

namespace modules\contract\models;

use Yii;

/**
 * This is the model class for table "contract_order".
 *
 * @property integer $contract_id
 * @property integer $order_id
 *
 * @property Order $order
 * @property Contract $contract
 */
class ContractOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contract_id', 'order_id'], 'required'],
            [['contract_id', 'order_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::className(), 'targetAttribute' => ['contract_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contract_id' => 'Contract ID',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\contract\models\query\ContractOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\contract\models\query\ContractOrderQuery(get_called_class());
    }
}
