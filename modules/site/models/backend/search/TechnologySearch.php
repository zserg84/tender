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

    public function rules() {
        return [
            [['title', 'text', 'directionName'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $query->lang();

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

        return $dataProvider;
    }

    public function attributeLabels(){
        return [
            'title' => 'Название',
            'text' => 'Текст',
            'directionName' => 'Направление',
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
} 