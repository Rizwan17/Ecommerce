<?php 
include "../../../utils.php";

loadController("Admin/Category");
$category = new Category();
$category->deleteCategoryById();

?>