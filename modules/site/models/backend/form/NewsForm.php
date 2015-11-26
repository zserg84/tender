<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 11:26
 */

namespace modules\site\models\backend\form;

use modules\base\behaviors\ImageBehavior;
use modules\site\models\News;

class NewsForm extends News
{

    public $title;
    public $text;
    public $images = [];
    public $dop_image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lit', 'source', 'source_image'], 'safe'],
            [['title', 'text', 'original_language_id'], 'required'],
            [['original_language_id', 'video_url', 'source', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'title' => 'Название',
                'text' => 'Текст',
                'original_language_id' => 'Оригинальный язык',
                'date' => 'Дата публикации',
                'images' => 'Картинки',
                'video_url' => 'Видео',
            ]
        );
    }

    public function behaviors()
    {
        return [
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
            ]
        ];
    }
} 