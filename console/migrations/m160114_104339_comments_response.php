<?php

use yii\db\Migration;

class m160114_104339_comments_response extends Migration
{
    public function up()
    {
        $this->addColumn('contract_comment', 'parent_id', $this->integer()->defaultValue(null));
        $this->addColumn('order_comment', 'parent_id', $this->integer()->defaultValue(null));

        $this->addForeignKey('fk_contr_comment_parent_id__contr_comment_id', 'contract_comment', 'parent_id', 'contract_comment', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_order_comment_parent_id__order_comment_id', 'order_comment', 'parent_id', 'order_comment', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('contract_comment', 'parent_id');
        $this->dropColumn('order_comment', 'parent_id');
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
