<?
use modules\contract\models\OrderComment;

foreach($comments as $comment):
    $contract = $comment->contract;
    $user = $contract->getUser();
    if(!$user)
        continue;

    $parentComment = null;
    if($comment->parent_id){
        $parentComment = OrderComment::findOne($comment->parent_id);
    }
    ?>
    <div class="row response-comment">
        <div class="col-sm-12">
            <p class="gray"><?=Yii::$app->getFormatter()->asDate($comment->created_at)?></p>
            <p><b><?=$user->name?></b></p>
            <?if($parentComment):?>
                <p>re: <?=$parentComment->contract->getUser()->name?> <?=Yii::$app->getFormatter()->asDate($parentComment->created_at)?></p>
            <?endif?>
            <p><?=$comment->text?></p>
        </div>
    </div>
<?endforeach?>