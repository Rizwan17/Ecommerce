<?php

loadController('Api');

class Category extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Category_Model');
        $this->model = new Category_Model();
    }

    public function getCategories(){
        return $this->model->getCategories();
    }

    public function addCategory(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }
        $categoryName = $this->JSON['categoryName'];
        $result = $this->model->addCategory($categoryName);
        $this->response($result);
    }

    public function updateCategoryById(){
        if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
            $this->invalidRequestType();
        }
        $categoryName = $this->JSON['categoryName'];
        $categoryId = $this->JSON['categoryId'];
        $result = $this->model->updateCategoryById($categoryId, $categoryName);
        $this->response($result);
    }
    public function deleteCategoryById(){
        if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
            $this->invalidRequestType();
        }
        $categoryId = $_GET['categoryId'];
        $result = $this->model->deleteCategoryById($categoryId);
        $this->response($result);
    }

    public function getCategoryById(){
        $categoryId = $_GET['categoryId'];
        $result = $this->model->getCategoryById($categoryId);
        $this->response($result);
    }
    

    
    
}

?>