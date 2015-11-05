<?
use yii\widgets\ListView;
?>
<div class="centerbar-wrapper">
    <div class="ad"><a href="#">Реклама</a></div>

    <div class="content-block">
        <h1>Технологии</h1>
        <h1><?=$direction->name?></h1>
    </div>

    <table class="orders">
        <tbody>
        <?
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'summary' => false,
        ]);
        ?>
        </tbody>
    </table>
</div>