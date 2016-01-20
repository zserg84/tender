<?
use modules\contract\Module as ContractModule;
use modules\contract\controllers\CommentController;
use modules\contract\models\ContractComment;

$buttons = $this->context->getButtons();
$profileContractId = $commentType == CommentController::MY_PROFILE_LIST ? $model->contract->id : $model->selfContract->id;
?>

<tr data-comment="<?=$model->id?>" data-contract="<?=$profileContractId?>">
    <td><p>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_ORDER_ID')?>: <?=$model->id?></b></span>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_TAPE_OF_ORDERS_DATE_OF_PLACEMENT')?>: <?=Yii::$app->getFormatter()->asDate($model->created_at)?></b></span>
        </p>
        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_AUTHOR')?>: <?=$model->contract->getUser()->login?></b></p>
    </td>
    <td>
        <p><b><?=$model->text?></b></p>
    </td>
    <td class="links">
        <p><span class="<?=ContractComment::getEstimateClass($model->estimate)?>"><?=ContractComment::getEstimateText($model->estimate)?></span></p>
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