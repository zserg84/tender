<?
use yii\bootstrap\Html;
use modules\base\components\Helper;
?>
<div>
    <div class="popup-wrapper">
        <strong><?=$modelLang->title?></strong>
        <div><p><?=$modelLang->text?></p></div>
        <div>
            <?if($model->image){
                echo Html::img($model->image->getSrc(), [
                    'width' => '300px'
                ]);
            }?>
        </div>
        <div>
            <?if($model->video_url){
                $iframe = '<iframe width="360" height="240" src="https://www.youtube.com/embed/'.Helper::getIdentifier($model->video_url).'" frameborder="0" allowfullscreen
                            style="background: white;
                            padding-top: 10px;
                            padding-bottom: 20px;
                            padding-left: 15px;
                            padding-right: 15px;
                            box-shadow: 0 0 10px rgba(0,0,0,0.5);"
                        ></iframe>';
                echo $iframe;
            }?>
        </div>
    </div>
</div>

<?
$this->registerJs('
    $("#modal-popup .modal-header .title").html("Технологии '.$model->date.'");
');