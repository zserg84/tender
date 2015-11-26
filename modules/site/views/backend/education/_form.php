<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\lang\models\Lang;
use kartik\date\DatePicker;
use dosamigos\fileinput\BootstrapFileInput;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
//    'enableClientValidation' => true,
    'options' => [
        'id' => 'education_form',
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'date')->widget(DatePicker::className(), [

            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'original_language_id')->dropDownList(ArrayHelper::map(Lang::find()->all(), 'id', 'name'))?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'title', ['options' => ['class' => 'form-group']]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'text', ['options' => ['class' => 'form-group']])->textarea();?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            $initialPreview = [];
            $previewConfig = [];
            if($formModel->images){
                foreach($formModel->images as $educationImage){
                    $image = $educationImage->image;
                    $initialPreview[] = '<img src="'.$image->getSrc().'" alt="" class="file-preview-image">';
                    $previewConfig[] = [
                        'url' => Url::toRoute(['image-delete']),
                        'key' => $image->id,
                    ];
                }
            }
            ?>
            <?= $form->field($formModel, 'images[]')->widget(BootstrapFileInput::className(), [
                'options' => ['accept' => 'image/*', 'multiple' => true],
                'clientOptions' => [
                    'browseClass' => 'btn btn-success',
                    'uploadClass' => 'btn btn-info',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
                    'showUpload' => false,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $previewConfig,
                    'showRemove' => false,
                    'overwriteInitial' => false,
                ]
            ])->error(false);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'video_url', ['options' => ['class' => 'form-group']]);?>
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