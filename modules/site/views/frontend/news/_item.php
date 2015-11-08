<?
use yii\helpers\Url;
?>
<tr>
    <td width="30px">
        <p><b><?=Yii::$app->getFormatter()->asDate($model->created_at)?></b></p>
    </td>
    <td>
        <div><p class="title"><a href="<?=Url::toRoute(['/site/news/get-modal-info', 'id'=>$model->id])?>"><?=$model->title?></a></p></div>
        <div><?
            if(strlen($model->text) > 200){
                $textBegin = mb_substr($model->text,0, 200, 'UTF-8');
                $textEnd = mb_substr($model->text,200, strlen($model->text), 'UTF-8');
            }
            else{
                $textBegin = $model->text;
                $textEnd = '';
            }
            echo '<span class="visible-text">'.$textBegin.'</span>';
            if($textEnd){
                echo '<span class="hidden-text">'.$textEnd.'</span>';
                echo '<a href="javascript:void(0)" class="more">читать далее...</a>';
            }
            ?>
        </div>
    </td>
</tr>
<tr class="space">
    <td colspan="3"></td>
</tr>