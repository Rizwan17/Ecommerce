<?php

loadController('Api');

class User extends Api {

    public $model = null;

    function __construct(){
        parent::__construct();
        loadModel("User_Model");
        $this->model = new User_Model();
    }


    public function login(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            return $this->invalidRequestType();
        
        $this->validateInput($this->JSON);
        
        $email = $this->JSON['email'];
        $password = $this->JSON['password'];

        $result = $this->model->login($email, $password);
        $this->response($result);
    }

    public function signup(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            return $this->invalidRequestType();
        
        $this->validateInput($this->JSON);
        
        $name = $this->JSON['name'];
        $email = $this->JSON['email'];
        $password = $this->JSON['password'];

        $result = $this->model->signup($name, $email, $password);
        $this->response($result);
    }

    public function addAddress(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            return $this->invalidRequestType();
        
        //ALTER TABLE `delivery_addresses` ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_info`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
        $userId = $_SESSION['uid'];
        $name = $this->JSON['name'];
        $address = $this->JSON['address'];
        $city = $this->JSON['city'];
        $state = $this->JSON['state'];
        $zip_code = $this->JSON['zip_code'];
        $phone_number = $this->JSON['phone_number'];
    
        $result = $this->model->addAddress($userId, $name, $address, $city, $state, $zip_code, $phone_number);
        $this->response($result);
    }

    public function logout(){
        unset($_SESSION["uid"]);
        unset($_SESSION["name"]);

        header('location:/' . APP_DIR_NAME);
    }

    public function fetchUserAddress(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
            return $this->invalidRequestType();

        $userId = $_SESSION['uid'];
        $result = $this->model->fetchUserAddress($userId);
        $this->response($result);
    }
    
}

?>