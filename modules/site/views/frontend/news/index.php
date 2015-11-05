<?
use yii\widgets\ListView;
?>
<div class="ad"><a href="#">Реклама</a></div>

<div class="content-block">
    <h1>Новости</h1>
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