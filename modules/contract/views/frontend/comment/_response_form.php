<?
use yii\widgets\ActiveForm;
use modules\contract\models\form\CommentForm;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin(
    [
//        'enableAjaxValidation' => false,
        'id' => 'comment_form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'action' => $action,
        'options' => [
            'id' => 'comment_form',
            'data-comment-action' => '',
        ]
    ]
);
$model = isset($model) ? $model : new CommentForm();
$model->self_contract_id = $contract ? $contract->id : null;

echo $form->field($model, 'self_contract_id')->hiddenInput()->label(false);
?>
    <div class="form-group" data-comment="form-group">
        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('text')?></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'text')->textarea(['rows' => 5])->label(false)?>
            </div>
        </div>

        <div class="row capcha">
            <div class="cols-sm-3">
                <?=Html::submitButton($model->getAttributeLabel('response_comment'))?>
            </div>
        </div>
    </div>
<?ActiveForm::end();
