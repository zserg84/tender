<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.11.15
 * Time: 23:15
 */
use yii\widgets\Pjax;

Pjax::begin(['id'=>'pjax_news_lang_container', 'enablePushState'=>false]);

echo $this->render('_lang_form', [
    'model' => $model,
    'formModel' => $formModel,
    'newsModel' => $newsModel,
]);

Pjax::end();