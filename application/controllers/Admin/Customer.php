<?php

loadController('Api');

class Customer extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('User_Model');
        $this->model = new User_Model();
    }

    public function getCustomers(){
        $result = $this->model->getCustomers();
        return $result;
    }

  
}

?>