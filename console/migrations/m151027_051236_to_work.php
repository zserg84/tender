<?php

use yii\db\Migration;

class m151027_051236_to_work extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_order_performer_id__contract_id', 'order');
        $this->dropIndex('fk_order_performer_id__contract_id', 'order');
        $this->dropColumn('order', 'performer_id');

        $this->createTable('contract_order', [
            'contract_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_contract_order', 'contract_order', 'contract_id, order_id');

        $this->addForeignKey('fk_contract_order_contract_id__contract_id', 'contract_order', 'contract_id', 'contract', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_contract_order_order_id__order_id', 'contract_order', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('contract_order');
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
