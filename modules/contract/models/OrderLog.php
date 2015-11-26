<?php

namespace modules\contract\models;

use modules\users\models\frontend\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property integer $status
 * @property integer $created_at
 *
 * @property Order $order
 * @property User $user
 */
class OrderLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id', 'status'], 'required'],
            [['user_id', 'order_id', 'status', 'created_at'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'created_at' => 'Created At',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\contract\models\query\OrderLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\contract\models\query\OrderLogQuery(get_called_class());
    }
}
