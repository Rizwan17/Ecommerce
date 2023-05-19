<?php

class Category_Model {

    public $con = null;

    public function __construct(){

        $servername = HOST;
        $username = USER;
        $password = PASSWORD;
        $db = DATABASE_NAME;

        // Create connection
        $this->con = mysqli_connect($servername, $username, $password,$db);
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