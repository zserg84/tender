<?php
echo $this->render('/../frontend/order/_create_modal', [
    'model' => $model,
    'order' => $order,
    'contract' => $contract,
]);