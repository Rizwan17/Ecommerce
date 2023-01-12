<?php

define('PRODUCT_LIMIT', 9);

class Product{

    private function array_result($query){
        $result = [];
        while($row = mysqli_fetch_array($query)){
            array_push($result, $row);
        }
        return $result;
    }

    public function getProducts($pageno){
        $limit = PRODUCT_LIMIT;
        $start = $pageno !== 0 ? ($pageno * $limit) - $limit : 0;
        $product_query = "SELECT * FROM products LIMIT $start, $limit";
        $run_query = mysqli_query($con,$product_query);
        if(mysqli_num_rows($run_query) > 0){
            return array_result($run_query);
        }else{
            return [];
        }
    }
}

?>