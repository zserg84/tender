<?
use modules\contract\Module as ContractModule;

$buttons = $this->context->getButtons();
?>

<tr data-comment="<?=$model->id?>" data-order="<?=$model->order_id?>">
    <td>
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