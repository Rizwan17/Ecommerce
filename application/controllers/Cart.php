<?php

loadController('Api');

class Cart extends Api {

    public $model = null;

    function __construct(){
        parent::__construct();
        loadModel("Cart_Model");
        $this->model = new Cart_Model();
    }


    public function getUserCartDetails(){
       if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
       }else{
            $userId = $_SESSION['uid'];
            $result = $this->model->getUserCartDetails($userId);
            $this->response($result);
       }
    }

    public function addToCart(){
        if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
            $this->invalidRequestType();
        }else{
            $userId = $_SESSION['uid'];
            
            if(array_key_exists('productId', $this->JSON)){
                $productId = $this->JSON['productId'];
                $result = $this->model->addToCart($userId, $productId);
            }else if(array_key_exists('cart', $this->JSON)){
                $cart = $this->JSON['cart'];
                $result = $this->model->updateCart($userId, $cart);
            }

            
            $this->response($result);
        }
    }
    
}

?>