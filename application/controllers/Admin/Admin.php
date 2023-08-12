<?php

loadController('Api');

class Admin extends Api {
    public $model = null;
    public function __construct(){
        parent::__construct();
        loadModel('Admin_Model');
        $this->model = new Admin_Model();
    }

    public function login(){
		if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }

        $email = $this->JSON['email'];
        $password = $this->JSON['password'];

        $result = $this->model->login($email, $password);
        $this->response($result);

	}

    public function register(){
		if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->invalidRequestType();
        }

        $name = $this->JSON['name'];
        $email = $this->JSON['email'];
        $password = $this->JSON['password'];

        $result = $this->model->register($name, $email, $password);
        $this->response($result);

	}

    public function getAdminList(){
		$results = $this->model->getAdminList();
        return $results;
	}

    public function deleteAdmin(){
    }

    public function logout(){
        unset($_SESSION["admin_name"]);
        unset($_SESSION["admin_id"]);
        $this->response(["status" => 200, 'message' => 'Logout Successfully']);
    }

    



    
}

?>