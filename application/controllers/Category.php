<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Category{

    public $model = null;

    public function __construct(){
        loadModel("Category_Model");
        $this->model = new Category_Model();
    }

    public function getCategories(){
        return $this->model->getCategories();
    }
}

// $category = new Category();
// $categories = $category->getCategories();
// print_r($categories);

?>