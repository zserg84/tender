<?php

use common\components\Modal;
use modules\themes\Module as ThemeModule;

Modal::begin([
    'clientOptions' => false,
    'id' => 'user-profile-modal',
    'header' => '<p class="title">'.ThemeModule::t('ALL_INTERFACES', 'USER_INFO_PROFILE').' "'.$user->name.'"</p>',
    'clientOptions' => false,
    'options' => [],
]);
echo $this->render('_customer_form', [
    'model' => $model,
]);

Modal::end();