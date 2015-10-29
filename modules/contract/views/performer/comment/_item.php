<?
use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\orders\CustomerProfileButton;
use modules\contract\widgets\actionButtons\performers\ProfileButton;

$buttons = $this->context->getButtons();
?>

<tr data-comment="<?=$model->id?>" data-contract="<?=$model->contract_id?>">
    <td>
        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_AUTHOR')?>: <?=$model->contract->getUser()->login?></b></p>
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

//            if($btn == CustomerProfileButton::className() && !$model->contract->customer_id)
//                continue;
//            if($btn == ProfileButton::className() && !$model->contract->performer_id)
//                continue;
            ?>
            <p><?=$btn::widget($params)?></p>
        <?endforeach;?>
    </td>
</tr>
<tr class="space">
    <td colspan="3"></td>
</tr>