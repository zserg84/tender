<?
use yii\helpers\Html;
use modules\direction\models\Direction;

$newBlock = isset($newBlock) ? $newBlock : true;

if($newBlock){
    echo Html::beginTag('div', ['class'=>'categories-filtr']);
}
$checkboxes = Yii::$app->getRequest()->post('filter_direction_checkbox', []);
$directionTree = isset($directionTree) ? $directionTree : Direction::getTree();
if($directionTree):
?>
<ul>
<?
foreach($directionTree as $direction){
  $active = in_array($direction->id, $checkboxes);
    ?>
    <li>
        <label class="costum-checkbox <?=($active ? 'active' : '')?>">
            <span><?=$direction->getName()?></span>
            <?=Html::checkbox('filter_direction_checkbox[]', $active, [
                'value' => $direction->id,
            ])?>
        </label>
        <?
        if($direction->children){
            echo $this->render('_direction', [
                'directionTree' => $direction->children,
                'newBlock' => false,
            ]);
        }
        ?>
    </li>
<?
}
?>
</ul>
<?endif;
if($newBlock){
    echo Html::endTag('div');
}