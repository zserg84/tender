<?php
namespace common\components;

use Yii;
use yii\web\AssetBundle;
use modules\contract\Module as ContractModule;

class BootboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/bootbox';
    public $js = [
        'bootbox.js',
    ];

    public static function overrideSystemConfirm()
    {
        Yii::$app->view->registerJs('
            yii.confirm = function(message, ok, cancel) {
                $("button[data-bb-handler=cancel]").html("asd");
//                bootbox.confirm(message, function(result) {
//                    if (result) { !ok || ok(); } else { !cancel || cancel(); }
//                });
                bootbox.dialog({
                    title: "<p class=\'title\'>&nbsp;</p>",
                    message: "<p>"+message+"</p>",
                    className: "confirm-popup",
                    buttons: {
                        success: {
                          label: "'.ContractModule::t('GUEST_INTERFACE', 'BUTTON_OK_GUESTINTERFACE').'",
                          className: "btn-success",
                          callback: function() {
                            ok();
                          }
                        },
                        danger: {
                          label: "'.ContractModule::t('GUEST_INTERFACE', 'BUTTON_CANCEL_GUESTINTERFACE').'",
                          className: "btn-danger",
                          callback: function() {
                          }
                        },
                    },
//                    callback: function(result){
//                        if (result) { !ok || ok(); } else { !cancel || cancel(); }
//                    }
                });

                $(".bootbox-close-button").html("");
            }
        ');
    }
}