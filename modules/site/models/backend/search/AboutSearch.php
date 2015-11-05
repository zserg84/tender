<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.11.15
 * Time: 10:43
 */

namespace modules\site\models\backend\search;

use modules\site\models\AboutLang;
use yii\data\ActiveDataProvider;

class AboutSearch extends AboutLang
{

    public function rules() {
        return [
            [['title', 'text'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'about_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'about_lang.text', $this->text]);


        return $dataProvider;
    }

    public function attributeLabels(){
        return [
            'title' => 'Название',
            'text' => 'Текст',
        ];
    }
} 