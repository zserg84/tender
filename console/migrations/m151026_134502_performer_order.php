<?php

use yii\db\Migration;

class m151026_134502_performer_order extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'performer_id', $this->integer().' COMMENT "Исполнитель, которому отдали заказ"');
        $this->addForeignKey('fk_order_performer_id__contract_id', 'order', 'performer_id', 'contract', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('order', 'performer_id');
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
