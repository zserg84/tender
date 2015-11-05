<?php

use common\components\Modal;
use modules\contract\Module as ContractModule;

Modal::begin([
    'id' => 'settings-popup',
    'header' => '<p class="title">'.ContractModule::t('CUSTOMER_INTERFACE', 'USER_INFO_SETTINGS').'</p>',
    'footer' => '
        <button id="settings_submit">'.ContractModule::t('FORM_CUSTOMER_SETTINGS', 'BUTTON_OK').'</button>
        <button class="cancelBtn">'.ContractModule::t('FORM_CUSTOMER_SETTINGS', 'BUTTON_CANCEL').'</button>
    ',
    'clientOptions' => false,
]);
echo $this->render('_customer_form', [
    'model' => $model,
    'setting' => $setting,
]);

$this->registerJs('
    $(document).on("click", "#settings_submit", function(){
        var form = $(this).closest(".modal-content").find(".modal-body form");
        form.submit();
    });
');
Modal::end();