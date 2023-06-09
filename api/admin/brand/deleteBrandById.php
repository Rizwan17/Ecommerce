<?php 
include "../../../utils.php";

loadController("Admin/Brand");
$brand = new Brand();
$brand->deleteBrandById();

?>