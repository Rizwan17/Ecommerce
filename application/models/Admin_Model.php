<?php

loadModel('Model');
class Admin_Model extends Model {

    public function __construct(){
        parent::__construct();
    }

    public function login($email, $password){
        try{
            $sql = "SELECT * FROM admin WHERE email = '$email' LIMIT 1";
            $rows = $this->mysqli_array_result($this->con, $sql);
            if(count($rows) > 0){
                $encoded_password = $rows[0]['password'];
                if(password_verify($password, $encoded_password)){
                    $_SESSION['admin_name'] = $rows[0]['name'];
				    $_SESSION['admin_id'] = $rows[0]['id'];

                    return $this->returnResult(200, 'Login Success');
                }
                return $this->returnResult(400, 'Incorrect Email or Password');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
	}

    public function getAdminList(){
		$sql = "SELECT `id`, `name`, `email`, `is_active` FROM `admin` WHERE 1";
        $rows = $this->mysqli_array_result($this->con, $sql);
        return $this->returnResult(200, null, $rows);
	}
}

?>