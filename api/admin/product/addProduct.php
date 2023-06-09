<?php
include "../../../utils.php";

loadController('Admin/Product');
$product = new Product();

$product->addProduct();

?>