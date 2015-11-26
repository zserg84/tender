<?php

use yii\db\Migration;

class m151105_164110_original_language extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'original_language_id', $this->integer());
        $this->addColumn('technology', 'original_language_id', $this->integer());
        $this->addColumn('article', 'original_language_id', $this->integer());
        $this->addColumn('education', 'original_language_id', $this->integer());

        $this->addForeignKey('fk_news_original_language_id__lang_id', 'news', 'original_language_id', 'lang', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_technology_original_language_id__lang_id', 'technology', 'original_language_id', 'lang', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_article_original_language_id__lang_id', 'article', 'original_language_id', 'lang', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_education_original_language_id__lang_id', 'education', 'original_language_id', 'lang', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('news', 'original_language_id');
        $this->dropColumn('technology', 'original_language_id');
        $this->dropColumn('article', 'original_language_id');
        $this->dropColumn('education', 'original_language_id');
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
