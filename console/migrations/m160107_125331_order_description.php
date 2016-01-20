<?php

use yii\db\Migration;

class m160107_125331_order_description extends Migration
{
    public function up()
    {
        $this->alterColumn('order', 'description', 'text');
    }

    public function down()
    {
        $this->alterColumn('order', 'description', 'VARCHAR(45)');
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
