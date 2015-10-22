<?
use modules\themes\tender\ThemeAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\contract\Module as ContractModule;

$zeroid=substr($model->id + 10000000000, 1, 11);
$imgPath = ThemeAsset::imgSrc('', 'img');
$buttons = $this->context->getButtons();
?>
<tr data-order="<?=$model->id?>" data-contract="<?=$model->contract_id?>">
    <td class="desc">
        <p>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_ORDER_ID')?>: <?=$zeroid?></b></span>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_DATE_OF_PLACEMENT')?>: <?=$model->date_publish?></b></span>
        </p>
        <p><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_SHORT_DESCRIPTION')?>: <?=$model->short_description?></b></p>
    </td>
    <td>
        <p><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_BUDGET')?>: <?=$model->budget?></b></p>
        <p><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_NUMBER')?>: <?=$model->count?></b></p>
    </td>
    <td class="links">
        <?foreach ($buttons as $button) :?>
            <p><?=$button::widget([
                    'model' => $model,
                    'pjaxContainerId' => 'pjax-order-modal-container',
                ])?>
            </p>
        <?endforeach;?>
    </td>
</tr>
<tr class="space">
    <td colspan="3"></td>
</tr>