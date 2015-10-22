<?
use common\components\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\contract\Module as ContractModule;

$contract = $model;

Modal::begin([
    'id' => 'offer-order-modal',
    'header' => '<p class="title">'.ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'FORM_NAME_OFFER_OF_THE_ORDER_TO_PERFORMER').'</p>',
    'footer' => '
        <button id="offer_form_submit">'.ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'OFFER_OF_THE_ORDER_TO_PERFORMER_CONFIRM').'</button>
        <button class="cancelBtn">'.ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'OFFER_OF_THE_ORDER_TO_PERFORMER_CANCEL_BUTTON').'</button>',
    'clientOptions' => false,
    'options' => [
        'data-comment' => 'modal',
    ],
]);

?>
<div class="popup-wrapper">
    <?
    $form = ActiveForm::begin(
        [
            'action' => Url::toRoute(['offer-order', 'contractId' => $contract->id]),
            'enableAjaxValidation' => true,
            'options' => [
                'id' => 'offer_order_form',
            ]
        ]
    );
    ?>
    <table class="offer-orders">
        <tbody>
        <?foreach($orders as $order):?>
            <tr>
                <td class="first">
                    <label class="costum-checkbox">
                        <input type="checkbox" name="order[]" value="<?=$order->id?>">
                        &nbsp;
                    </label>
                </td>
                <td>
                    <p><?=ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'OFFER_OF_THE_ORDER_TO_PERFORMER_ORDER')?></p>
                </td>
                <td>
                    <p><b><?=ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'OFFER_OF_THE_ORDER_TO_PERFORMER_ID')?> <?=$order->id?></b></p>
                </td>
                <td>
                    <p><?=$order->short_description?></p>
                </td>
                <td class="last">
                    <p><b><?=ContractModule::t('FORM_OFFER_OF_THE_ORDER_TO_PERFORMER', 'OFFER_OF_THE_ORDER_TO_PERFORMER_BUDGET')?></b> <span class="green"><?=$order->budget?> <?=$order->currency->name?>.</span></p>
                </td>
            </tr>
            <tr class="space">
                <td colspan="5"></td>
            </tr>
        <?endforeach?>
        </tbody>
    </table>
    <?ActiveForm::end()?>
</div>
<?
Modal::end();
$this->registerJS('
    $(document).on("click", "#offer_form_submit", function(){
        $("#offer_order_form").submit();
    });
');