<?php

use yii\db\Migration;

class m151105_164756_date extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'date', $this->date());
        $this->addColumn('technology', 'date', $this->date());
        $this->addColumn('article', 'date', $this->date());
        $this->addColumn('education', 'date', $this->date());

        $this->addColumn('news', 'source', $this->string());

        $this->addColumn('news', 'image_id', $this->integer());
        $this->addColumn('technology', 'image_id', $this->integer());
        $this->addColumn('article', 'image_id', $this->integer());
        $this->addColumn('education', 'image_id', $this->integer());
        $this->addForeignKey('fk_news_image_id__image_id', 'news', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_technology_image_id__image_id', 'technology', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_article_image_id__image_id', 'article', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_education_image_id__image_id', 'education', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');

        $this->addColumn('news', 'video_url', $this->string());
        $this->addColumn('technology', 'video_url', $this->string());
        $this->addColumn('article', 'video_url', $this->string());
        $this->addColumn('education', 'video_url', $this->string());
    }

    public function down()
    {
        $this->dropColumn('news', 'date');
        $this->dropColumn('technology', 'date');
        $this->dropColumn('article', 'date');
        $this->dropColumn('education', 'date');

        $this->dropColumn('news', 'source');

        $this->dropColumn('news', 'video_url');
        $this->dropColumn('technology', 'video_url');
        $this->dropColumn('article', 'video_url');
        $this->dropColumn('education', 'video_url');

        $this->dropColumn('news', 'image_id');
        $this->dropColumn('technology', 'image_id');
        $this->dropColumn('article', 'image_id');
        $this->dropColumn('education', 'image_id');
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
