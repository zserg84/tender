<?php

use yii\db\Migration;

class m151104_091649_pages_menu_date extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'created_at', $this->integer()->notNull());
        $this->addColumn('technology', 'created_at', $this->integer()->notNull());
        $this->addColumn('article', 'created_at', $this->integer()->notNull());
        $this->addColumn('education', 'created_at', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('news', 'created_at');
        $this->dropColumn('technology', 'created_at');
        $this->dropColumn('article', 'created_at');
        $this->dropColumn('education', 'created_at');
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
