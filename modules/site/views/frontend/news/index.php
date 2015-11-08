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

<?
$this->registerJs('
    $(document).on("click", ".list-block .title a", function(){
        $.get($(this).attr("href"), function(data){
            $("#modal-popup .modal-body").html(data);
            $("#modal-popup .modal-footer").html("<button class=\"cancelBtn\">'.ThemeModule::t('themes-site', 'close_button').'</button>");
            $("#modal-popup").modal();
        });
        return false;
    });
');