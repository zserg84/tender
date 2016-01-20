<?php

use yii\db\Migration;

class m160120_125659_favorite_add_date extends Migration
{
    public function up()
    {
        $this->addColumn('favorite_company', 'created_at', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('favorite_company', 'created_at');
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
