<?php

use yii\db\Migration;

class m160118_113954_of_to_customer_alter extends Migration
{
    public function up()
    {
        $this->alterColumn('offer_to_customer', 'price', 'decimal(18,2)');
    }

    public function down()
    {
        $this->alterColumn('offer_to_customer', 'price', 'decimal(10,2)');
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
