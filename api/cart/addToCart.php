<?php

include "../../utils.php";

loadController('Cart');

$cart = new Cart();
$cart->addToCart();


?>