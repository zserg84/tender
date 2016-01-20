<?php
echo $this->render('/../frontend/comment/response', [
    'model' => $model,
    'contract' => $contract,
    'parentComment' => $parentComment,
]);