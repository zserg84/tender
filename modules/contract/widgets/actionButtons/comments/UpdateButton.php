<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 28.10.15
 * Time: 15:08
 */

namespace modules\contract\widgets\actionButtons\comments;

use modules\contract\widgets\actionButtons\Button;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\contract\Module as ContractModule;

class UpdateButton extends Button
{
    const MODAL_ID = 'comment-update-modal';

    public function init()
    {
        $this->button = Html::a(ContractModule::t('PERFORMER_INTERFACE', 'VIEW_ELEMENT_COMMENT_EDIT_LINK'), "javascript:void(0)", [
            'class' => 'comment_update_link'
        ]);

        $this->jsHandler = '
            $(".comment_update_link").click(function() {
                var url = "' . Url::toRoute(['/contract/comment/update']) . '";
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