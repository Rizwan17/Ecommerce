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
            $payment_status = isset($this->JSON['payment_status']) ? $this->JSON['payment_status'] : null;
            $trx_id = isset($this->JSON['trx_id']) ? $this->JSON['trx_id'] : null;
            $userId = $_SESSION['uid'];

            $result = $this->model->createOrder($userId, $cart, $addressId, $paymode, $payment_status, $trx_id);
            $this->response($result);

        }
    }

    public function fetchOrderDetails(){
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            $this->invalidRequestType();
        }else{
            
            $userId = $_SESSION['uid'];
            $orderId = $_GET['orderId'];

            $result = $this->model->fetchOrderDetails($orderId);
            //$this->response($result);
            return $result;
            
        }
    }
}


?>