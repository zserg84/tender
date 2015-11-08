<?php

use modules\themes\admin\widgets\Box;
use modules\site\widgets\modellang\EducationLangFormWidget;

$this->title = 'Обучение';
$this->params['subtitle'] = 'Редактирование';
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];

$boxButtons[] = '{create}';

$boxButtons[] = '{delete}';

$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'formModel' => $formModel,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>

<h3>Переводы</h3>
<?=EducationLangFormWidget::widget([
    'educationModel' => $model,
]);