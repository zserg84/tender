<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.10.15
 * Time: 15:10
 */

namespace modules\contract\widgets\actionButtons\comments;


use modules\contract\widgets\actionButtons\Button;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\contract\Module as ContractModule;

class ResponseButton extends Button
{
    const MODAL_ID = 'comment-response-modal';

    public function init()
    {
        $this->button = Html::a(ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_RESPONSE_LINK'), "javascript:void(0)", [
            'class' => 'comment_response_link'
        ]);

        $this->jsHandler = '
            $(".comment_response_link").click(function() {
                var url = "' . Url::toRoute(['/contract/comment/response']) . '";
                $.pjax({url: url, container: "#'.$this->pjaxContainerId.'", data:{id: $(this).closest("tr").data("comment")}, push:false, replace:false});
            });

            $("#'.$this->pjaxContainerId.'").on("pjax:end", function() {
                initPopup();
                initPage();
                $("#'.self::MODAL_ID.'").modal();
            });
        ';

        parent::init();
    }
} 