<?php
echo $this->render('/../frontend/order/responses', [
    'responses' => $responses,
    'contractOrder' => $contractOrder,
    'buttons' => $buttons,
]);