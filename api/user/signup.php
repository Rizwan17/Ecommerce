<?php

include "../../utils.php";

loadController('User');
$user = new User();

$user->signup();


?>