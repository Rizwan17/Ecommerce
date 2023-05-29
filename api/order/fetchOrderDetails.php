<?php
include_once("../../utils.php");

loadController('Order');
$order = new Order();

$order->fetchOrderDetails();

?>