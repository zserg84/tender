<?php
use common\components\Modal;
use modules\themes\Module as ThemeModule;
use modules\contract\widgets\actionButtons\comments\ResponseButton;
use yii\helpers\Url;

$modalId = ResponseButton::MODAL_ID;

Modal::begin([
    'id' => $modalId,
    'header' => '<p class="title">'.ThemeModule::t('ALL_INTERFACES', 'RESPONSE_COMMENT').'</p>',
    'clientOptions' => false,
    'options' => [
        'data-comment' => 'modal',
    ],
]);
?>
    <div class="popup-wrapper">
        <div><?=$parentComment->contract->getUser()->name.' '. Yii::$app->getFormatter()->asDate($parentComment->created_at) .' : '?></div>
        <div><?=$parentComment->text?></div>
        <?
        echo $this->render('_response_form', [
            'model' => $model,
            'contract' => $contract,
            'action' => Url::toRoute(['/contract/comment/response', 'id'=>$parentComment->id]),
            'actionType' => 'update'
        ]);?>
    </div>
<?Modal::end();