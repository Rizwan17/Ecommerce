<?php
loadModel("Model");

class Category_Model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function getCategories(){
        $category_query = "SELECT * FROM categories";
        $run_query = mysqli_query($this->con,$category_query) or die(mysqli_error($this->con));
        $categories = [];
        if(mysqli_num_rows($run_query) > 0){
            while($row = mysqli_fetch_array($run_query, MYSQLI_ASSOC)){
                array_push($categories, $row);
            }
        }
        return $categories;
    }
}


?>