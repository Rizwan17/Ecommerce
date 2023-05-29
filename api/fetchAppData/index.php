<?php

include "../../utils.php";

loadController("AppData");

$appData = new AppData();
$appData->fetchAppData();

?>