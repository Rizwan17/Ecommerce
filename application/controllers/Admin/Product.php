<?php

loadController('Api');

class Product extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Product_Model');
        $this->model = new Product_Model();
    }

    public function getAllProducts(){
        return $this->model->getProducts();
    }

    public function addProduct(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        } 

        $this->validateInput($_POST);

        $productName = $_POST['productName'];
        $brandId = $_POST['brandId'];
        $categoryId = $_POST['categoryId'];
        $productDescription = $_POST['productDescription'];
        $productQty = $_POST['productQty'];
        $productPrice = $_POST['productPrice'];
        $productKeywords = $_POST['productKeywords'];

        $productImage = $_FILES['productImage'];
        $filePath = basename(time() . "_" . $productImage['name']);
        $targetDir = imageUploadDir($filePath);
        
        $file_uploaded = move_uploaded_file($productImage['tmp_name'], $targetDir);

        if($file_uploaded){
            $result = $this->model->addProduct(
                $productName,
                $brandId,
                $categoryId,
                $productDescription,
                $productQty,
                $productPrice,
                $productKeywords,
                $filePath
            );
            $this->response($result);
        }
    }

    public function updateProduct(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        } 

        $this->validateInput($_POST);

        $productId = $_POST['productId'];
        $productName = $_POST['productName'];
        $brandId = $_POST['brandId'];
        $categoryId = $_POST['categoryId'];
        $productDescription = $_POST['productDescription'];
        $productQty = $_POST['productQty'];
        $productPrice = $_POST['productPrice'];
        $productKeywords = $_POST['productKeywords'];

        $filePath = null;
        if(isset($_FILES['productImage']['name'])){
            $productImage = $_FILES['productImage'];
            $filePath = basename(time() . "_" . $productImage['name']);
            $targetDir = imageUploadDir($filePath);
            
            move_uploaded_file($productImage['tmp_name'], $targetDir);
        }

        $result = $this->model->updateProduct(
            $productId,
            $productName,
            $brandId,
            $categoryId,
            $productDescription,
            $productQty,
            $productPrice,
            $productKeywords,
            $filePath
        );
        $this->response($result);
    }

    public function deleteProductById(){
        if($_SERVER['REQUEST_METHOD'] !== "DELETE"){
            $this->invalidRequestType();
        } 
        
        $productId = $_GET['productId'];
        $result = $this->model->deleteProductById($productId);
        $this->response($result);
    }


    public function fetchProductDetails(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }
        $productId = $this->JSON['productId'];
        $result = $this->model->getProductById($productId);
        $this->response($result);
    }

    // "Cannot delete or update a parent row: a foreign key constraint fails (`khanstore`.`order_details`, CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`))"


    
    
}

?>