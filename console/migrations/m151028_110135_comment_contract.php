<?php

use yii\db\Migration;

class m151028_110135_comment_contract extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_contract_comment_comment_contract', 'contract_comment');
        $this->renameColumn('contract_comment', 'comment_contract_id', 'self_contract_id');
        $this->addForeignKey('fk_contract_comment_self_contract_id__contract_id', 'contract_comment', 'self_contract_id', 'contract', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->renameColumn('contract_comment', 'self_contract_id', 'comment_contract_id');
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
