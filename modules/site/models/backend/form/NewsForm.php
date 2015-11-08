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
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'original_language_id'], 'required'],
            [['original_language_id', 'image_id', 'video_url', 'source', 'date'], 'safe'],
            [['image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>'Допустимы только файлы jpg, png, gif'],
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
                'image' => 'Картинка',
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