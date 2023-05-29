<?php

loadController('Api');
class Order extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Order_Model');
        $this->model = new Order_Model();
    }

    public function createOrder(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }else{

            $cart = $this->JSON['cart'];
            $addressId = $this->JSON['addressId'];
            $paymode = $this->JSON['paymode'];
            $userId = $_SESSION['uid'];

            $result = $this->model->createOrder($userId, $cart, $addressId, $paymode);
            $this->response($result);

            //$this->

        }
    }

    public function fetchOrderDetails(){
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            $this->invalidRequestType();
        }else{
            
            $userId = $_SESSION['uid'];
            $orderId = $_GET['orderId'];

            $result = $this->model->fetchOrderDetails($userId, $orderId);
            //$this->response($result);
            return $result;
            
        }
    }
}


?>