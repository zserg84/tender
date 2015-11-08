<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:34
 */

namespace modules\site\models\backend\search;


use modules\site\models\Article;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
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
        $query->select(['article.*']);

//        $query->lang();
        $query->innerJoinWith([
            'langs' => function($query){

            }
        ]);
        $query->andWhere(
            'article_lang.lang_id = article.original_language_id'
        );
        $query->addSelect([
            'article_lang.title', 'article_lang.text'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'article_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'article_lang.text', $this->text]);
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