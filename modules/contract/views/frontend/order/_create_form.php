<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use modules\contract\models\Currency;
use modules\direction\models\Direction;
use modules\contract\models\OrderHasDirection;
use kartik\depdrop\DepDrop;
use modules\contract\models\Order;

$yesno = [1=>\Yii::$app->getFormatter()->asBoolean(1), 0=>\Yii::$app->getFormatter()->asBoolean(0)];

$disabled = !in_array($order->status, [Order::STATUS_PREPARED, Order::STATUS_TEMP_REMOVE]);
if($order->isNewRecord)
    $disabled = false;

$form = ActiveForm::begin(
    [
        'enableAjaxValidation' => true,
//        'validateOnChange' => false,
//        'validateOnBlur' => false,
        'enableClientValidation' => false,
        'options' => [
            'id' => 'order_create_form',
            'enctype' => 'multipart/form-data',
        ]
    ]
);

$orderId = isset($model->orderId) ? $model->orderId : '';
if($orderId)
    echo $form->field($model, 'orderId')->hiddenInput(['name'=>'orderId'])->error(false)->label(false);
?>
    <div class="popup-wrapper">

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('registration_date')?></p>
            </div>
            <div class="col-sm-8">
                <p><?=date('d.m.Y')?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('user')?></p>
            </div>
            <div class="col-sm-8">
                <p><?=$model->getUser()?></p>
            </div>
        </div>

        <div class="row margin0">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('directions')?></p>
            </div>
            <div class="col-sm-8 ">
                <div class="order-direction direction-block col-sm-12">
                    <?
                    $directions = ArrayHelper::map(Direction::find()->andWhere(['parent_id'=>null])->all(), 'id', 'name');
                    $subdirections = Direction::find()->where(['is not', 'parent_id', null])->all();
                    $ohds = OrderHasDirection::find()->where([
                        'order_id' => $orderId,
                    ])->all();
                    foreach($ohds as $ohd):
                        $subdirection = $ohd->direction;
                        $direction = $subdirection->parent;
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="order-direction-spec-main[]" value="<?=$direction->id?>" />
                                <input type="hidden" name="order-direction-spec-second[]" value="<?=$subdirection->id?>" />
                                <p class="spec-string"><?=$direction->getName()?>, <?=$subdirection->getName()?>
                                    <?if(!$disabled):?>
                                    <span class="close-ico"></span>
                                    <?endif?>
                                </p>
                            </div>
                        </div>
                    <?endforeach?>
                    <div class="row">
                        <?
                        $orderDirectionId = 'order-direction-id-'.$orderId;
                        $orderSubDirectionId = 'order-subdirection-id-'.$orderId;
                        ?>
                        <div class="col-sm-6 spec-main-select">
                            <?=Html::dropDownList('select-spec-main-select' ,false, $directions, [
                                'id'=>$orderDirectionId,
                                'disabled' => $disabled,
                            ])?>
                        </div>
                        <div class="col-sm-6 spec-second-select">
                            <?
                            echo DepDrop::widget([
                                'name' => 'order-subdirection',
                                'data' => ArrayHelper::map(Direction::find()->where(['parent_id' => key($directions)])->all(), 'id', 'name'),
                                'options'=>[
                                    'id'=>$orderSubDirectionId,
                                    'disabled' => $disabled,
                                ],
                                'pluginOptions'=>[
                                    'depends'=>[$orderDirectionId],
                                    'url'=>Url::toRoute(['/../users/guest/get-subdirection']),
                                ],
                                'pluginEvents' => [
                                    "depdrop.afterChange" => "function(event, id, value) {
                                        var oDropdown = $('#".$orderSubDirectionId."').msDropdown().data('dd');
                                        oDropdown.destroy();
                                        oDropdown = $('#".$orderSubDirectionId."').msDropdown().data('dd');
                                        oDropdown.refresh();
                                    }
                                "
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <?if(!$disabled):?>
                    <div class="row">
                        <div class="col-sm-4 add pull-right">
                            <a href="#"><?=$model->getAttributeLabel('add_button')?> +</a>
                        </div>
                    </div>
                    <?endif?>
                </div>
                <?=$form->field($model, 'subdirection_ids')->hiddenInput([
                    'disabled' => 'disabled'
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('note')?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('short_description')?></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'short_description')->textInput([
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('description')?></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'description')->textInput([
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('date_performance')?></p>
            </div>
            <div class="col-sm-4">
                <?$model->date_performance = $model->date_performance ? Yii::$app->getFormatter()->asDate($model->date_performance) : null?>
                <?=$form->field($model, 'date_performance')->textInput([
                    'class'=>'datepicker',
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('date_publish')?></p>
            </div>
            <div class="col-sm-4">
                <?$model->date_publish = $model->date_publish ? Yii::$app->getFormatter()->asDate($model->date_publish) : null?>
                <?=$form->field($model, 'date_publish')->textInput([
                    'class'=>'datepicker',
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('material')?></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'material')->textInput([
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('file_model_id')?></p>
            </div>
            <div class="col-sm-8">
                <?
                $options = [
                    'class' => 'customfile-input costum-file-model',
                    'data-text' => $model->getAttributeLabel('file_model_upload'),
                ];
                if($disabled)
                    $options['disabled'] = $disabled;
                ?>
                <?=$form->field($model, 'file_model_id')->fileInput($options)->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('file_model_note')?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('count')?></p>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'count')->textInput([
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('budget')?></p>
            </div>
            <div class="col-sm-4">
                <?=$form->field($model, 'budget')->textInput([
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(Currency::find()->all(), 'id', 'name'), [
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('material_belongs_customer')?></p>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'material_belongs_customer')->dropDownList($yesno, [
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('material_included_budget')?></p>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'material_included_budget')->dropDownList($yesno, [
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('has_modeling')?></p>
            </div>
            <div class="col-sm-2">
                <?=$form->field($model, 'has_modeling')->dropDownList($yesno, [
                    'disabled' => $disabled,
                ])->label(false)?>
            </div>
        </div>

        <?
        if(!$order->isNewRecord){
            $statuses = [];
            if($order->status == Order::STATUS_OPEN){
                $statuses = [Order::STATUS_OPEN => Order::STATUS_OPEN,
                    Order::STATUS_TEMP_REMOVE => Order::STATUS_TEMP_REMOVE,
                    Order::STATUS_CLOSE => Order::STATUS_CLOSE,
                ];
            }
            elseif($order->status == Order::STATUS_PREPARED){
                $statuses = [
                    Order::STATUS_OPEN => Order::STATUS_OPEN,
                    Order::STATUS_PREPARED => Order::STATUS_PREPARED,
                    Order::STATUS_CLOSE => Order::STATUS_CLOSE,
                ];
            }
            elseif($order->status == Order::STATUS_WORK){
                if($contract->isCustomer()){
                    $statuses = [
                        Order::STATUS_WORK => Order::STATUS_WORK,
                        Order::STATUS_CLOSE => Order::STATUS_CLOSE,
                    ];
                }
                elseif($contract->isPerformer()){
                    $statuses = [
                        Order::STATUS_WORK => Order::STATUS_WORK,
                        Order::STATUS_REFUSE => Order::STATUS_REFUSE,
                        Order::STATUS_DONE => Order::STATUS_DONE,
                    ];
                }
            }
            elseif($order->status == Order::STATUS_TEMP_REMOVE){
                $statuses = [
                    Order::STATUS_OPEN => Order::STATUS_OPEN,
                    Order::STATUS_TEMP_REMOVE => Order::STATUS_TEMP_REMOVE,
                    Order::STATUS_CLOSE => Order::STATUS_CLOSE,
                ];
            }
            elseif($order->status == Order::STATUS_CLOSE){
                $statuses = [
                    Order::STATUS_CLOSE => Order::STATUS_CLOSE,
                ];
            }
            elseif($order->status == Order::STATUS_REFUSE){
                $statuses = [
                    Order::STATUS_REFUSE => Order::STATUS_REFUSE,
                ];
            }
            elseif($order->status == Order::STATUS_DONE){
                $statuses = [
                    Order::STATUS_DONE => Order::STATUS_DONE,
                    Order::STATUS_FINISHED_ACCEPT => Order::STATUS_FINISHED_ACCEPT,
                    Order::STATUS_FINISHED_FAIL => Order::STATUS_FINISHED_FAIL,
                ];
            }
            else{
                $statuses[$order->status] = $order->status;
            }
        }
        else
            $statuses = [Order::STATUS_OPEN => Order::STATUS_OPEN, Order::STATUS_PREPARED => Order::STATUS_PREPARED];

        $statusesArray = [];
        foreach($statuses as $k=>$status){
            $statuses[$k] = Order::getStatus($status);
        }
        ?>
        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('status')?></p>
            </div>
            <div class="col-sm-8">
                <?=$form->field($model, 'status')->dropDownList($statuses)->label(false)?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <p><?=$model->getAttributeLabel('image_id')?></p>
            </div>
            <div class="col-sm-8">
                <?
                $options = [
                    'class' => 'customfile-input costum-file-order-photo',
                    'data-text' => $model->getAttributeLabel('image_upload'),
                ];
                if($disabled)
                    $options['disabled'] = $disabled;
                ?>
                <?=$form->field($model, 'file_model_id')->fileInput($options)->label(false)?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?=Html::submitButton($model->getAttributeLabel('submit_button')); ?>
            <button class="cancelBtn"><?=$model->getAttributeLabel('cancel_button')?></button>
        <? ActiveForm::end();?>
    </div>
<?
$this->registerJS("
//    $('#costum-file-model').parent().find('.customfile-feedback').html(' ".$model->getAttributeLabel('file_model_upload')."');
//	$('#costum-file-order-photo').parent().find('.customfile-feedback').html('".$model->getAttributeLabel('image_upload')."');
");

/*валидация форм*/
/*$js = <<<JS
jQuery('#order_create_form').on('beforeSubmit', function(){
    var form = jQuery(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (response, status, xhr) {
            response = xhr.responseJSON;
            response = jQuery.parseJSON(response);
            console.log("error");console.log(response.error);
            if(response.output == 'error'){
                $.each(response.error, function (id, msg) {
                    var formgroup = $('#' + id).closest('.form-group');
                    formgroup.addClass("has-error");
                    formgroup.find('.help-block').html(msg);
                });
            }
        }
    });
    return false;
})
JS;
$this->registerJs($js);*/