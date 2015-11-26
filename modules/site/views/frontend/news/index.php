<?
use yii\widgets\ListView;
use modules\themes\Module as ThemeModule;
?>
<div class="ad"><a href="#">Реклама</a></div>

<div class="content-block">
    <h1>Новости</h1>
</div>

<table class="list-block">
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