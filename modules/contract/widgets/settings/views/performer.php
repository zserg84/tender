<?php

use common\components\Modal;
use modules\contract\Module as ContractModule;

Modal::begin([
    'id' => 'settings-popup',
    'header' => '<p class="title">'.ContractModule::t('PERFORMER_INTERFACE', 'PERFORMER_SETTINGS').'</p>',
    'footer' => '
        <button id="settings_submit">'.ContractModule::t('FORM_PERFORMER_SETTINGS', 'PERFORMER_SETTINGS_CANCEL_BUTTON').'</button>
        <button class="cancelBtn">'.ContractModule::t('FORM_PERFORMER_SETTINGS', 'PERFORMER_SETTINGS_SAVE_BUTTON').'</button>
    ',
    'clientOptions' => false,
]);
echo $this->render('_performer_form', [
    'model' => $model,
    'setting' => $setting,
]);

$this->registerJs('
    $(document).on("click", "#settings_submit", function(){
        var form = $(this).closest(".modal-content").find(".modal-body form");
        form.trigger("submit");
        return false;
    });
');
Modal::end();