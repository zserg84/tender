<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\lang\models\Lang;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
//    'enableClientValidation' => true,
    'options' => [
        'id' => 'about_form',
    ]
]); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'lang_id')->dropDownList(ArrayHelper::map(Lang::find()->all(), 'id', 'name'))?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'title', ['options' => ['class' => 'form-group']])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'text', ['options' => ['class' => 'form-group']])?>
        </div>
    </div>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton('Сохранить',
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>