<?
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use modules\contract\models\Contract;
use modules\contract\widgets\comment\CommentWidget;
use yii\widgets\Pjax;
?>

    <div class="ad"><a href="#">Реклама</a></div>

    <table class="performers">
        <tbody>
        <?
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'summary' => false,
            'viewParams' => [],
            'layout' => "{items}"
        ]);
        ?>
        </tbody>
    </table>
    <div>
        <?
        echo LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]);
        ?>
    </div>
<?
Pjax::begin(['id' => 'pjax-item-modal-container', 'enablePushState' => false,]);
Pjax::end();

if(!Yii::$app->getUser()->getIsGuest())
    CommentWidget::widget([
        'contract' => new Contract(),
    ]);?>