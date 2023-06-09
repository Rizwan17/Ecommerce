<?php

loadController('Api');

class Brand extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Brand_Model');
        $this->model = new Brand_Model();
    }

    public function getBrands(){
        return $this->model->getBrands();
    }

    
    public function addBrand(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }
        $brandName = $this->JSON['brandName'];
        $result = $this->model->addBrand($brandName);
        $this->response($result);
    }

    public function updateBrandById(){
        if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
            $this->invalidRequestType();
        }
        $brandName = $this->JSON['brandName'];
        $brandId = $this->JSON['brandId'];
        $result = $this->model->updateBrandById($brandId, $brandName);
        $this->response($result);
    }
    public function deleteBrandById(){
        if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
            $this->invalidRequestType();
        }
        $brandId = $_GET['brandId'];
        $result = $this->model->deleteBrandById($brandId);
        $this->response($result);
    }

    public function getBrandById(){
        $brandId = $_GET['brandId'];
        $result = $this->model->getBrandById($brandId);
        $this->response($result);
    }
    

    
    
}

?>