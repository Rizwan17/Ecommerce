<?php

class Product{

    public $model = null;

    public function __construct(){
        loadModel("Product_Model");
        $this->model = new Product_Model();
    }

    public function getProducts(){
        return $this->model->getProducts();
    }

    public function getProductsByCategory($category){
        return $this->model->getProductsByCategory($category);
    }

    public function getProductById($productId){
        return $this->model->getProductById($productId);
    }
}

// $category = new Category();
// $categories = $category->getCategories();
// print_r($categories);

?>