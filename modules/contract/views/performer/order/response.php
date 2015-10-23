<?
use common\components\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\contract\models\Currency;
use modules\contract\Module as ContractModule;

Modal::begin([
    'id' => 'response-modal',
    'header' => '<p class="title">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'FORM_NAME_ANSWER_OF_THE_PERFORMER_TO_ORDER').'</p>',
    'footer' => '
        <div class="tip">
        <p style="text-align: left">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_NOTE').'</p></div>
        <button id="response_form_submit">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_OK_BUTTON').'</button>
        <button class="cancelBtn">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_CANCEL_BUTTON').'</button>',
    'clientOptions' => false,
]);

?>
    <div class="popup-wrapper">
        <?
        $form = ActiveForm::begin(
            [
                'action' => Url::toRoute(['response', 'orderId' => $order->id]),
                'enableAjaxValidation' => true,
                'validateOnChange' => false,
                'validateOnBlur' => false,
                'options' => [
                    'id' => 'response_order_form',
                ]
            ]
        );
        ?>
        <div class="row">
            <div class="col-sm-4">
                <p><b><?=ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_PROPOSAL_OF_THE_PERFORMER')?><span>*</span></b></p>
            </div>
            <div class="col-sm-6">
                <?=$form->field($model, 'price')->textInput(['class'=>''])->label(false)->error(false)?>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(Currency::find()->all(), 'id', 'name'))->label(false)->error(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><b><?=ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_COMMENT')?></b></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'description')->textarea(['rows'=>5])->label(false)->error(false)?>
            </div>
        </div>
        <?ActiveForm::end()?>
    </div>
<?
Modal::end();
$this->registerJS('
    $(document).on("click", "#response_form_submit", function(){
        $("#response_order_form").submit();
    });
');