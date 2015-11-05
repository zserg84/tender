<?php

use modules\themes\admin\widgets\Box;

$this->title = 'Технологии';
$this->params['subtitle'] = 'Создание';
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
]; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-primary'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => '{cancel}'
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'formModel' => $formModel,
                'box' => $box,
            ]
        );
        Box::end(); ?>
    </div>
</div>