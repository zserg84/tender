<?
use common\components\Modal;
use modules\contract\Module as ContractModule;
use yii\widgets\Pjax;

Modal::begin([
    'id' => 'response-list-popup',
    'header' => '<p class="title">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'FORM_NAME_ANSWER_OF_THE_PERFORMER_TO_ORDER').'</p>',
    'footer' => '
        <button class="cancelBtn">'.ContractModule::t('FORM_ANSWER_OF_THE_PERFORMER_TO_ORDER', 'ANSWER_OF_THE_PERFORMER_TO_ORDER_CANCEL_BUTTON').'</button>',
    'clientOptions' => false,
]);
?>
    <div class="popup-wrapper">
        <table class="performers">
            <tbody>
            <?foreach($responses as $response):
                $contract = $response->contract;
                $user = $contract->getUser();
                $zeroid = $user->getZeroId();
                if($contractOrder && $contractOrder->contract_id != $contract->id)
                    $disStyle = "background: #D5D4D4";
                else
                    $disStyle = '';
                ?>
                <tr data-contract="<?=$contract->id?>" style="<?=$disStyle?>">
                    <td class="ava">
                        <img src="<?=$user->getLogo()?>" alt="" width="78" height="57">
                    </td>
                    <td class="desc">
                        <p>
                            <span><b>ID <?=$zeroid?></b></span>
                            <span><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_RESPONSES_ADDRESS')?>:</b>
                                <?=$contract->city->country->name.', '.$contract->city->name?>
                            </span>
                        </p>
                        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_RESPONSES_PERFORMER_OFFER')?></b> <span class="green"><b><?=$response->price?> руб</b></span></p>
                        <p><b><?=ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_PERFORMERS_RESPONSES_OFFER_COMMENTS')?>:</b><?=$response->description?></p>
                    </td>
                    <td class="links">
                        <?if(!$contractOrder):?>
                            <?foreach ($buttons as $button) :
                                $btn = $button['class'];
                                $params = isset($button['params']) ? $button['params'] : [];
                                $params = array_merge([
                                    'pjaxContainerId' => 'pjax-order-modal-container',
                                ], $params);
                                ?>
                                <p><?=$btn::widget($params)?>
                                </p>
                            <?endforeach;?>
                        <?endif?>
                    </td>
                </tr>

                <tr class="space">
                    <td colspan="3"></td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
<?
Modal::end();