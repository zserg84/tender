<?php

use yii\db\Migration;

class m151104_052120_pages_menu extends Migration
{
    public function up()
    {
        $this->createTable('about_lang', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ]);
        $this->addForeignKey('fk_about_lang_lang_id__lang_id', 'about_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_about_lang_lang_id', 'about_lang', 'lang_id', true);

        $this->createTable('news', [
            'id' => $this->primaryKey()
        ]);
        $this->createTable('news_lang', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ]);
        $this->addForeignKey('fk_news_lang_news_id__news_id', 'news_lang', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_news_lang_lang_id__lang_id', 'news_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_news_lang_news_id_lang_id', 'news_lang', 'lang_id, news_id', true);

        $this->createTable('technology', [
            'id' => $this->primaryKey(),
            'direction_id' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk_technology_direction_id__direction_id', 'technology', 'direction_id', 'direction', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('technology_lang', [
            'id' => $this->primaryKey(),
            'technology_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ]);
        $this->addForeignKey('fk_technology_lang_technology_id__technology_id', 'technology_lang', 'technology_id', 'technology', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_technology_lang_lang_id__lang_id', 'technology_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_technology_lang_technology_id_lang_id', 'technology_lang', 'lang_id, technology_id', true);

        $this->createTable('article', [
            'id' => $this->primaryKey()
        ]);
        $this->createTable('article_lang', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ]);
        $this->addForeignKey('fk_article_lang_article_id__article_id', 'article_lang', 'article_id', 'article', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_article_lang_lang_id__lang_id', 'article_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_article_lang_article_id_lang_id', 'article_lang', 'lang_id, article_id', true);

        $this->createTable('education', [
            'id' => $this->primaryKey()
        ]);
        $this->createTable('education_lang', [
            'id' => $this->primaryKey(),
            'education_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ]);
        $this->addForeignKey('fk_education_lang_education_id__education_id', 'education_lang', 'education_id', 'education', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_education_lang_lang_id__lang_id', 'education_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_education_lang_education_id_lang_id', 'education_lang', 'lang_id, education_id', true);

        $this->createTable('partner', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
        ]);

        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('contact');
        $this->dropTable('partner');
        $this->dropTable('education_lang');
        $this->dropTable('education');
        $this->dropTable('article_lang');
        $this->dropTable('article');
        $this->dropTable('technology_lang');
        $this->dropTable('technology');
        $this->dropTable('news_lang');
        $this->dropTable('news');
        $this->dropTable('about_lang');
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
