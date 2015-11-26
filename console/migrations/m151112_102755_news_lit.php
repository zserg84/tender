<?php

use yii\db\Migration;

class m151112_102755_news_lit extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'lit', $this->string());
        $this->addColumn('news', 'source_image', $this->string());

        $this->dropForeignKey('fk_news_image_id__image_id', 'news');
        $this->dropColumn('news', 'image_id');
        $this->dropForeignKey('fk_article_image_id__image_id', 'article');
        $this->dropColumn('article', 'image_id');
        $this->dropForeignKey('fk_technology_image_id__image_id', 'technology');
        $this->dropColumn('technology', 'image_id');
        $this->dropForeignKey('fk_education_image_id__image_id', 'education');
        $this->dropColumn('education', 'image_id');

        $this->createTable('news_image', [
            'news_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_news_image', 'news_image', 'news_id, image_id');
        $this->addForeignKey('fk_news_image_news_id_image_id__news_id', 'news_image', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_news_image_image_id_image_id__image_id', 'news_image', 'image_id', 'image', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('article_image', [
            'article_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_article_image', 'article_image', 'article_id, image_id');
        $this->addForeignKey('fk_article_image_article_id_image_id__article_id', 'article_image', 'article_id', 'article', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_article_image_image_id_image_id__image_id', 'article_image', 'image_id', 'image', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('technology_image', [
            'technology_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_technology_image', 'technology_image', 'technology_id, image_id');
        $this->addForeignKey('fk_technology_image_technology_id_image_id__technology_id', 'technology_image', 'technology_id', 'technology', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_technology_image_image_id_image_id__image_id', 'technology_image', 'image_id', 'image', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('education_image', [
            'education_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_education_image', 'education_image', 'education_id, image_id');
        $this->addForeignKey('fk_education_image_education_id_image_id__education_id', 'education_image', 'education_id', 'education', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_education_image_image_id_image_id__image_id', 'education_image', 'image_id', 'image', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m151112_102755_news_lit cannot be reverted.\n";

        return false;
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
