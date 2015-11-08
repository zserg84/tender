<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 22:04
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\lang\models\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'action' => Url::toRoute(['lang-form', 'newsId'=>$newsModel->id]),
    'enableAjaxValidation' => true,
//    'enableClientValidation' => true,
    'options' => [
        'id' => 'news_translate_form',
    ]
]); ?>
    <?= $form->field($formModel, 'news_id')->hiddenInput()->label(false)->error(false);?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'lang_id')->dropDownList(ArrayHelper::map(Lang::find()->where([
                '<>', 'id', $newsModel->original_language_id
            ])->all(), 'id', 'name'), [
                'onchange' => '
                    $.pjax({
                        url: "'.Url::toRoute(['/site/news/lang-form', 'newsId'=>$newsModel->id]).'",
                        data: {langId: $(this).val()},
                        container: "#pjax_news_lang_container",
                        push: false,
                        replace: false
                    });
                ',
            ])?>
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

<?= Html::submitButton('Сохранить',
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>