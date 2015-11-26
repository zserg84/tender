<?php

use yii\db\Migration;

class m151117_050532_order_log extends Migration
{
    public function up()
    {
        $this->createTable('order_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_order_log_user_id__users_id', 'order_log', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_log_order_id__order_id', 'order_log', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('order_log');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
