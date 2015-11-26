<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.11.15
 * Time: 16:16
 */

namespace modules\contract\widgets\actionButtons\performers;

use modules\contract\Module as ContractModule;
use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;

class ChoosePerformer extends Button
{

    public $orderId;

    public function init(){
        $this->button = Html::a(ContractModule::t('ALL_INTERFACES', 'VIEW_ELEMENT_CHOOSE_PERFORMER_BUTTON'),
            'javascript:void(0)',
            [
                'class' => 'choose_performer_link'
            ]);

        $this->jsHandler = '
            $(document).on("click", ".choose_performer_link", function() {
                var url = "'.Url::toRoute(['/contract/performer/choose-performer', 'orderId'=>$this->orderId]).'";
//                $.pjax({url: url, container: "#'.$this->pjaxContainerId.'", data:{contractId: $(this).closest("tr").data("contract")}, push:false, replace:false});
                $.ajax({
                    url: url,
                    data:{contractId: $(this).closest("tr").data("contract")},
                    error: function (xhr, status, error) {
                        alert("error");
                    },
                    success: function (result, status, xhr) {console.log(result);
                        $.pjax({
                            url: "'.Url::toRoute(['responses', 'orderId'=>$this->orderId]).'",
                            container: "#'.$this->pjaxContainerId.'",
                            push: false,
                            replace:false
                        });
                    }
                });
            });
        ';

        parent::init();
    }
} 