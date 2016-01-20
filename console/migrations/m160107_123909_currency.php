<?php

use yii\db\Migration;

class m160107_123909_currency extends Migration
{
    public function up()
    {
        $this->addColumn('currency', 'short_name', $this->string(25));

        $this->update('currency', ['short_name'=>'Руб.'], [
            'id' => 1
        ]);
        $this->update('currency', ['short_name'=>'Дол.'], [
            'id' => 2
        ]);
    }

    public function down()
    {
        $this->dropColumn('currency', 'short_name');
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
