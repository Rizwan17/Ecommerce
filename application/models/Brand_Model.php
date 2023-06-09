<?php
loadModel("Model");

class Brand_Model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function getBrands(){
        $sql = "SELECT * FROM brands";
        $rows = $this->mysqli_array_result($this->con, $sql);
        return $rows;
    }
    
    public function addBrand($brandName = null){
        try{
            if($brandName !== null){
                $sql = "INSERT INTO brands (brand_title) VALUES ('$brandName')";
                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, '1 New Brand Added Successfully');
                }
                return $this->returnResult(200, 'Something went wrong');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function deleteBrandById($brandId = null){
        try{
            if($brandId !== null){
                $sql = "DELETE FROM brands WHERE brand_id = '$brandId'";
                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(200, '1 Brand Removed');
                }
                return $this->returnResult(200, 'Something went wrong');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function updateBrandById($brandId = null, $brandName = null){
        try{
            if($brandId !== null && $brandName !== null){
                $sql = "UPDATE brands SET brand_title = '$brandName' WHERE brand_id = '$brandId'";
                mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, '1 Brand Updated');
                }
                return $this->returnResult(200, 'Something went wrong');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }
    public function getBrandById($brandId = null){
        try{
            if($brandId !== null){
                $sql = "SELECT * FROM brands WHERE brand_id = '$brandId'";
                $rows = $this->mysqli_array_result($this->con, $sql);
                return $this->returnResult(200, null, $rows[0]);
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }
}


?>