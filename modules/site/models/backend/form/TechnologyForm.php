<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:20
 */

namespace modules\site\models\backend\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\site\models\Technology;

class TechnologyForm extends Technology
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
            [['title', 'text', 'original_language_id'], 'required'],
            [['original_language_id', 'video_url', 'date', 'direction_id'], 'safe'],
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
                'direction_id' => 'Направление',
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