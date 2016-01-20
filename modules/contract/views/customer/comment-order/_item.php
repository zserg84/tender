<?
use modules\contract\Module as ContractModule;
use modules\contract\controllers\CommentOrderController;

$buttons = $this->context->getButtons();

//$profileContractId = $commentType == CommentOrderController::MY_ORDERS_LIST ? $model->contract->id : $model->order->contract->id;
$profileContractId = $model->contract->id;
?>

<tr data-comment="<?=$model->id?>" data-order="<?=$model->order_id?>" data-contract="<?=$profileContractId?>">
    <td>
        <p>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_ORDER_ID')?>: <?=$model->id?></b></span>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_DATE_OF_PLACEMENT')?>: <?=Yii::$app->getFormatter()->asDate($model->created_at)?></b></span>
        </p>
        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_AUTHOR')?>: <?=$model->contract->getUser()->login?></b></p>
        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_ORDER')?>: <?=$model->order->short_description?></b></p>
    </td>
    <td>
        <p><b><?=$model->text?></b></p>
    </td>
    <td class="links">
        <?foreach ($buttons as $button) :
            $btn = $button['class'];
            $params = isset($button['params']) ? $button['params'] : [];
            $params = array_merge([
                'model' => $model,
                'pjaxContainerId' => 'pjax-item-modal-container',
            ], $params);
            ?>
            <p><?=$btn::widget($params)?>
            </p>
        <?endforeach;?>
    </td>
</tr>
<tr class="space">
    <td colspan="3"></td>
</tr>