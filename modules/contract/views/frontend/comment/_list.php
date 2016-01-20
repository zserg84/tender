<?
use modules\contract\Module as ContractModule;
use modules\contract\models\ContractComment;
?>
<?foreach($comments as $comment):
    $contract = $comment->contract;
    if(! ($user = $contract->customer)){
        $company = $contract->performer;
        if(!$company)
            continue;
        $user = $company->user;
        if(!$user)
            continue;
    }
    $parentComment = null;
    if($comment->parent_id){
        $parentComment = ContractComment::findOne($comment->parent_id);
    }
    ?>
    <div class="row response-comment">
        <div class="col-sm-12">
            <p class="gray"><?=Yii::$app->getFormatter()->asDate($comment->created_at)?></p>
            <p><b><?=ContractModule::t('FORM_ORDER', 'USER_CONTRACT')?>: <?=$user->name?></b></p>
            <?if($parentComment):?>
                <p>re: <?=$parentComment->contract->getUser()->name?> <?=Yii::$app->getFormatter()->asDate($parentComment->created_at)?></p>
            <?endif?>
            <p><?=$comment->text?></p>
        </div>
    </div>
<?endforeach?>