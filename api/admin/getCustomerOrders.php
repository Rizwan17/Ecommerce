<?php
include "../../utils.php";

loadController('Admin/Order');
$order = new Order();

$order->getCustomerOrders();

?>