<?
use modules\themes\tender\ThemeAsset;
use modules\contract\Module as ContractModule;

$imgPath = ThemeAsset::imgSrc('', 'img');

$company = $model->performer;
$user = $model->getUser();
if(!$user)
    return;

$zeroid = $user->getZeroId();
$buttons = $this->context->getButtons();
?>
<tr data-contract="<?=$model->id?>">
    <td class="ava">
        <img src="<?=$company->getLogo()?>" alt="" widht="78" height="57">
    </td>
    <td class="desc">
        <p>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_COMPANY_ID')?> <?=$zeroid?></b></span>
            <span><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_EXPERIENCE')?>:</b></span>
            <!-- <span><b>Адрес:</b>г.Москва&nbsp;ул.&nbsp;Сельскохозяйственная,...</span> -->
        </p>
        <p><b><?=ContractModule::t('GUEST_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_SPECIALIZATION')?>: <?=$company->specialization?></b></p>
    </td>
    <td class="links">
        <p><img src="<?=$imgPath?>rating.png" alt=""></p>
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