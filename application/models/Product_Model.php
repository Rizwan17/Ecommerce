<?php
loadModel("Model");

class Product_Model extends Model {

    public function __construct(){
        parent::__construct();
    }

    public function getProducts(){
        try{
            $sql = "SELECT * FROM products";
            $rows = $this->mysqli_array_result($this->con, $sql);
            return $this->returnResult(200, null, $rows);
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function getProductById($productId = null){
        try{
            $sql = "SELECT * FROM products WHERE product_id = '$productId'";
            $rows = $this->mysqli_array_result($this->con, $sql);
            $metaData = ['productImageBaseUrl' => imageBaseUrl()];
            return $this->returnResult(200, null, [ 'product' => $rows[0], 'metaData' => $metaData ]);
        }catch(Exception $e){
            $this->returnResult(500, $e->getMessage());
        }
    }

    public function getProductsByCategory($category = null){
        try{
            $sql = "SELECT * FROM products JOIN categories ON products.product_cat = categories.cat_id WHERE categories.cat_title = '$category'"; 
            $rows = $this->mysqli_array_result($this->con, $sql);
            return $this->returnResult(200, null, $rows);
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function addProduct(
        $productName = null,
        $brandId = null,
        $categoryId = null,
        $productDescription = null,
        $productQty = null,
        $productPrice = null,
        $productKeywords = null,
        $filePath = null
    ){
        try{
            if(
                $productName !== null &&
                $brandId !== null &&
                $categoryId !== null &&
                $productDescription !== null &&
                $productQty !== null &&
                $productPrice !== null &&
                $productKeywords !== null &&
                $filePath !== null 
            ){
                $sql = "INSERT INTO `products`(`product_cat`, `product_brand`, `product_title`, `product_price`, `product_qty`, `product_desc`, `product_image`, `product_keywords`) VALUES ('$categoryId','$brandId','$productName','$productPrice','$productQty','$productDescription','$filePath','$productKeywords')";
                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, '1 New Product Added Successfully!');
                }
                return $this->returnResult(200,  'Something went wrong');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function updateProduct(
        $productId = null,
        $productName = null,
        $brandId = null,
        $categoryId = null,
        $productDescription = null,
        $productQty = null,
        $productPrice = null,
        $productKeywords = null,
        $filePath = null
    ){
        try{
            if(
                $productName !== null &&
                $brandId !== null &&
                $categoryId !== null &&
                $productDescription !== null &&
                $productQty !== null &&
                $productPrice !== null &&
                $productKeywords !== null
            ){
                $sql = "UPDATE products SET ";
                $sql .= "product_cat='$categoryId', ";
                $sql .= "product_brand='$brandId', ";
                $sql .= "product_title='$productName', ";
                $sql .= "product_price='$productPrice', ";
                $sql .= "product_qty='$productQty', ";
                $sql .= "product_desc='$productDescription', ";
                if($filePath !== null){
                    $sql .= "product_image='$filePath', ";
                } 
                $sql .= "product_keywords='$productKeywords' ";
                $sql .= "WHERE product_id = '$productId'";

                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, 'Product Updated Successfully!');
                }
                return $this->returnResult(200,  'Something went wrong');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function deleteProductById($productId){
        try{
            if($productId !== null){
                $sql = "DELETE FROM products WHERE product_id = '$productId'";
                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(200, "Product Removed");
                }
                return $this->returnResult(200, "Something went wrong");
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    
}


?>