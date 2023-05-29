<?php

include "../../utils.php";

loadController('Order');
$order = new Order();
$order->createOrder();

?>