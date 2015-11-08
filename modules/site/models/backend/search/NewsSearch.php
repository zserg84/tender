<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 11:21
 */

namespace modules\site\models\backend\search;


use modules\site\models\News;
use yii\data\ActiveDataProvider;

class NewsSearch extends News
{
    private $_originalLanguageName;

    public function rules() {
        return [
            [['title', 'text', 'originalLanguageName'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $query->select(['news.*']);

//        $query->lang();
        $query->innerJoinWith([
            'langs' => function($query){

            }
        ]);
        $query->andWhere(
            'news_lang.lang_id = news.original_language_id'
        );
        $query->addSelect([
            'news_lang.title', 'news_lang.text'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'news_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'news_lang.text', $this->text]);
        $query->andFilterWhere(['=', 'lang.id', $this->_originalLanguageName]);

        return $dataProvider;
    }

    public function attributeLabels(){
        return [
            'title' => 'Название',
            'text' => 'Текст',
            'originalLanguageName' => 'Оригинальный язык'
        ];
    }

    public function getOriginalLanguageName(){
        if($this->_originalLanguageName)
            return $this->_originalLanguageName;
        return $this->originalLanguage ? $this->originalLanguage->name : null;
    }

    public function setOriginalLanguageName($value){
        $this->_originalLanguageName = $value;
    }
} 