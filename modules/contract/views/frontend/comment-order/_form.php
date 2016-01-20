<?
use yii\widgets\ActiveForm;
use modules\contract\models\form\OrderCommentForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;

$action = isset($action) ? $action : Url::toRoute(['create']);
$actionType = isset($actionType) ? $actionType : 'create';

$form = ActiveForm::begin(
    [
        'enableAjaxValidation' => false,
        'action' => $action,
        'options' => [
            'id' => 'comment_form',
            'data-comment-action' => $actionType,
        ]
    ]
);

$model = isset($model) ? $model : new OrderCommentForm();
$model->order_id = $order ? $order->id : null;

echo $form->field($model, 'order_id')->hiddenInput()->label(false);
?>
<div class="form-group" data-comment="form-group">
    <div class="row">
        <div class="col-sm-4">
            <p><?=$actionType == 'create' ? $model->getAttributeLabel('add_comment') : $model->getAttributeLabel('text')?></p>
        </div>
        <div class="col-sm-8">
            <?=$form->field($model, 'text')->textarea(['rows' => 5])->label(false)?>
        </div>
    </div>

    <div class="row capcha">
        <div class="cols-sm-3">
            <?=Html::submitButton($actionType == 'create' ? $model->getAttributeLabel('add_comment') : $model->getAttributeLabel('edit_comment'))?>
        </div>
    </div>
</div>
<?ActiveForm::end();