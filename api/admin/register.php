<?php

include "../../utils.php";

loadController('Admin/Admin');

$admin = new Admin();
$admin->register();

?>