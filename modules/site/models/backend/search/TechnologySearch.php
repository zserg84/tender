<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 13:19
 */

namespace modules\site\models\backend\search;

use yii\data\ActiveDataProvider;
use modules\site\models\Technology;

class TechnologySearch extends Technology
{
    private $_directionName;
    private $_originalLanguageName;

    public function rules() {
        return [
            [['title', 'text', 'directionName', 'originalLanguageName'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $query->select(['technology.*']);

//        $query->lang();
        $query->innerJoinWith([
            'langs' => function($query){

            }
        ]);
        $query->andWhere(
            'technology_lang.lang_id = technology.original_language_id'
        );
        $query->addSelect([
            'technology_lang.title', 'technology_lang.text'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->innerJoinWith(['direction']);

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'technology_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'technology_lang.text', $this->text]);
        $query->andFilterWhere(['LIKE', 'direction.name', $this->_directionName]);
        $query->andFilterWhere(['=', 'lang.id', $this->_originalLanguageName]);

        return $dataProvider;
    }

    public function attributeLabels(){
        return [
            'title' => 'Название',
            'text' => 'Текст',
            'directionName' => 'Направление',
            'originalLanguageName' => 'Оригинальный язык'
        ];
    }

    public function getDirectionName(){
        if($this->_directionName)
            return $this->_directionName;
        return $this->direction ? $this->direction->name : null;
    }

    public function setDirectionName($value){
        $this->_directionName = $value;
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