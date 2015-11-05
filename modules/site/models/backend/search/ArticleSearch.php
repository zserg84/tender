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

    public function rules() {
        return [
            [['title', 'text'], 'safe'],
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

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['LIKE', 'article_lang.title', $this->title]);
        $query->andFilterWhere(['LIKE', 'article_lang.text', $this->text]);

        return $dataProvider;
    }

    public function attributeLabels(){
        return [
            'title' => 'Название',
            'text' => 'Текст',
        ];
    }
} 