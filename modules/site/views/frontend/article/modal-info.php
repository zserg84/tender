<?
use yii\bootstrap\Html;
use modules\base\components\Helper;
use modules\themes\Module as ThemeModule;
?>
<div>
    <div class="popup-wrapper">
        <h4><strong><?=$modelLang->title?></strong></h4>
        <div><p><?=$modelLang->text?></p></div>
        <div style="height: 230px">
            <p><?if($model->images){
                    echo Html::img($model->images[0]->getSrc(), [
                        'width' => '132px',
                        'height' => '174px',
                        'class'=>"leftimg"
                    ]);
                }?><?=$modelLang->text?></p>
        </div>
        <div>
            <?if($model->images){
                foreach($model->images as $k=>$image){
                    if(!$k)
                        continue;
                    echo Html::img($image->getSrc(), [
                        'width' => '300px',
                        'height' => '200px',
                    ]);
                }

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
    $("#modal-popup .modal-header .title").html("Статьи '.$model->date.'");
    $("#modal-popup .modal-footer").html("<button class=\"cancelBtn\">'.ThemeModule::t('ALL_INTERFACES', 'MODAL_CLOSE_BUTTON').'</button>");
');