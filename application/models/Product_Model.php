<?php
loadModel("Model");

class Product_Model extends Model {

    public function __construct(){
        parent::__construct();
    }

    public function getProducts(){
        $product_query = "SELECT * FROM products";
        $run_query = mysqli_query($this->con,$product_query) or die(mysqli_error($this->con));
        $products = [];
        if(mysqli_num_rows($run_query) > 0){
            while($row = mysqli_fetch_array($run_query, MYSQLI_ASSOC)){
                array_push($products, $row);
            }
        }
        return $products;
    }

    public function getProductById($productId = null){
        $product_query = "SELECT * FROM products WHERE product_id = '$productId'";
        $run_query = mysqli_query($this->con,$product_query) or die(mysqli_error($this->con));
        $products = [];
        if(mysqli_num_rows($run_query) > 0){
            while($row = mysqli_fetch_array($run_query, MYSQLI_ASSOC)){
                array_push($products, $row);
            }
        }
        return $products;
    }

    public function getProductsByCategory($category = null){
        if($category === null) return [];
        $query = "SELECT * FROM products JOIN categories ON products.product_cat = categories.cat_id WHERE categories.cat_title = '$category'"; 
        // echo $query;
        // exit;
        $query_result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));
        $products = [];
        if(mysqli_num_rows($query_result) > 0){
            while($row = mysqli_fetch_array($query_result, MYSQLI_ASSOC)){
                array_push($products, $row);
            }
            return $products;
        }

        return $products;
    }

    
}


?>