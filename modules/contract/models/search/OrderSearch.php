<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.04.15
 * Time: 16:59
 */

namespace modules\contract\models\search;

use common\components\FilterModelBase;
use modules\contract\models\Contract;
use modules\contract\models\Order;
use modules\direction\models\Direction;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class OrderSearch extends FilterModelBase
{
    public $filter_specialization;

    public $filter_territory_country;
    public $filter_territory_state;
    public $filter_territory_city;

    public $filter_direction_checkbox;
    public $contract_id;

    public $withMyResponse;

    public function rules(){
        return [
            [['filter_specialization',
                'filter_territory_country', 'filter_territory_state', 'filter_territory_city',
                'filter_direction_checkbox',
            ], 'safe'],
        ];
    }

    public function search($params = []){
        $model = new Order();
        $model->load($params);
        $this->load($params, '');
        $query = $model->find();

        $query->andFilterWhere(['order.contract_id' => $this->contract_id]);

        if($this->withMyResponse){
            $curContract = Contract::getCurContract();
            $query->innerJoinWith([
                'offerToCustomers' => function($query) use($curContract){
                    $query->from('offer_to_customer as OTC');
                    $query->where([
                        'OTC.contract_id' => $curContract->id,
                    ]);
                }
            ]);
        }

        $query->innerJoinWith([
            'contract.city' => function($query) {
              if($this->filter_territory_city)
                $query->where(['city.ID' => $this->filter_territory_city]);
            }
        ]);

        $query->innerJoinWith([
            'contract.city.state' => function($query) {
              if($this->filter_territory_state)
                $query->where(['state.ID' => $this->filter_territory_state]);
            }
        ]);

        $query->innerJoinWith([
            'contract.city.country' => function($query) {
              if($this->filter_territory_country)
                $query->where(['country.ID' => $this->filter_territory_country]);
            }
        ]);
        
        if($this->filter_direction_checkbox){
          $directions = [];
          foreach($this->filter_direction_checkbox as $directionId){
            $dir = Direction::findOne($directionId);
            $directions = array_merge($directions, $dir->getAllChildrenArray());
          }
          $query->innerJoinWith([
              'directions' => function($query) use($directions){
                $query->where(['direction.ID' => $directions]);
              }
          ]);
        }

        $this->_dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => new Pagination([
                'pageSize' => $this->pageSize
            ])
        ]);

        return $this->_dataProvider;
    }
}