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
use yii\helpers\ArrayHelper;

class OrderSearch extends FilterModelBase
{
    public $contract_id;

    public $withMyResponse;

    public $toWork;

    public $myProfile;

    public function search($params = []){
        $model = new Order();
        $model->load($params);
        $query = $model->find();

        $query->andFilterWhere(['order.contract_id' => $this->contract_id]);

        $curContract = Contract::getCurContract();
        if($this->withMyResponse){
            $query->innerJoinWith([
                'offerToCustomers' => function($query) use($curContract){
                    $query->from('offer_to_customer as OTC');
                    $query->where([
                        'OTC.contract_id' => $curContract->id,
                    ]);
                }
            ]);
        }

        if($this->toWork){
            $query->andWhere([
                'performer_id' => $curContract->id
            ]);
        }

        if($this->myProfile){
            $directions = Direction::find()->innerJoinWith([
                'contractPerformerHasDirections' => function($query) use($curContract){
                    $query->from('contract_performer_has_direction as cphd');
                    $query->andWhere([
                        'cphd.contract_id' => $curContract->id
                    ]);
                }
            ])->all();
            $directions = ArrayHelper::getColumn($directions, 'id');
            $query->innerJoinWith([
                'orderHasDirections' => function($query) use($directions){
                    $query->from('order_has_direction as ohd');
                    $query->andWhere([
                        'ohd.direction_id' => $directions
                    ]);
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