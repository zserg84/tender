<?php

use modules\themes\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use modules\themes\admin\widgets\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use modules\lang\models\Lang;

$this->title = 'Технологии';
$this->params['subtitle'] = 'Список';
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'technology-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        'title',
        'text',
        'directionName',
        [
            'attribute' => 'originalLanguageName',
            'format' => 'raw',
            'filter' => Html::activeDropDownList($searchModel, 'originalLanguageName',
                ArrayHelper::map(Lang::find()->all(), 'id', 'name'),
                ['class'=>'form-control','prompt' => 'Все языки']
            ),
        ],
    ]
];

$boxButtons = $actions = [];

$boxButtons[] = '{create}';
$boxButtons[] = '{batch-delete}';

$actions[] = '{update}';
$actions[] = '{delete}';

$showActions = true;

$gridButtons = [];

if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'template' => implode(' ', $actions),
        'buttons'=>$gridButtons,
    ];
}

$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons,
                'grid' => $gridId,
            ]
        ); ?>
        <?=  GridView::widget($gridConfig);?>
        <?php Box::end(); ?>
    </div>
</div>