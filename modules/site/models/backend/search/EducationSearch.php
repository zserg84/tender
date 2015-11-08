<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:47
 */

namespace modules\site\models\backend\search;


use modules\site\models\Education;
use yii\data\ActiveDataProvider;

class EducationSearch extends Education
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
        $query->select(['education.*']);

//        $query->lang();
        $query->innerJoinWith([
            'langs' => function($query){

            }
        ]);
        $query->andWhere(
            'education_lang.lang_id = education.original_language_id'
        );
        $query->addSelect([
            'education_lang.title', 'education_lang.text'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'education_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'education_lang.text', $this->text]);
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