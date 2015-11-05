<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\lang\models\Lang;
use modules\direction\models\Direction;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
//    'enableClientValidation' => true,
    'options' => [
        'id' => 'news_form',
    ]
]); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'direction_id')->dropDownList(ArrayHelper::map(Direction::find()->andWhere(['parent_id'=>null])->all(), 'id', 'name'));?>
        </div>
    </div>
    <?
    $languages = Lang::find()->all();
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationTitle[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
                    $formModel->getAttributeLabel('translationTitle').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>
    <?
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationText[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
                    $formModel->getAttributeLabel('translationText').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton('Сохранить',
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>