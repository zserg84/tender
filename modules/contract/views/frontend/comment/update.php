<?php
use common\components\Modal;
use modules\themes\Module as ThemeModule;
use modules\contract\widgets\actionButtons\comments\UpdateButton;
use yii\helpers\Url;

$modalId = UpdateButton::MODAL_ID;

Modal::begin([
    'id' => $modalId,
    'header' => '<p class="title">'.ThemeModule::t('ALL_INTERFACES', 'UPDATE_COMMENT').'</p>',
    'clientOptions' => false,
    'options' => [
        'data-comment' => 'modal',
    ],
]);
?>
    <div class="popup-wrapper">
    <?
    echo $this->render('_form', [
        'model' => $model,
        'contract' => $contract,
        'action' => Url::toRoute(['/contract/comment/update', 'id'=>$comment->id]),
        'actionType' => 'update'
    ]);?>
    </div>
<?Modal::end();