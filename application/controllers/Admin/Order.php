<?php

loadController('Api');

class Order extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Order_Model');
        $this->model = new Order_Model();
    }

    public function getCustomerOrders(){
        $result = $this->model->getCustomerOrders();
        return $result;
    }

    public function fetchOrderDetailsById(){
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            $this->invalidRequestType();
        }

        $orderId = $_GET['orderId'];
        $result = $this->model->fetchOrderDetails($orderId);
        $this->response($result);
    }

    public function updateOrderStatus(){
        if($_SERVER["REQUEST_METHOD"] !== "POST"){
            $this->invalidRequestType();
        }

        $orderId = $this->JSON['orderId'];
        $orderStatus = $this->JSON['orderStatus'];
        $status = '';

        switch($orderStatus){
            case "CONFIRMED":
                $status = "CONFIRMED";
                break;
            case "SHIPPED":
                $status = "SHIPPED";
                break;
            case "OUT_FOR_DELIVERY":
                $status = "OUT_FOR_DELIVERY";
                break;
            case "DELIVERED":
                $status = "DELIVERED";
                break;
            default:
                $status = null;
                break;
        }

        $result = $this->model->updateOrderStatus($orderId, $status);
        $this->response($result);
    }
    
}

?>