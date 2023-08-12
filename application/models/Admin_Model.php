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

    public function register($name, $email, $password){
        try{
            $find_admin_sql = "SELECT id FROM admin WHERE email = '$email'";
            $rows = $this->mysqli_array_result($this->con, $find_admin_sql);
            if(count($rows) > 0){
                return $this->returnResult(400, 'Email already exists');
            }
            $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
            $sql = "INSERT INTO `admin`(`name`, `email`, `password`) VALUES ('$name','$email','$hash_password')";
            mysqli_query($this->con, $sql);
            if(mysqli_affected_rows($this->con) > 0){
                return $this->returnResult(201, 'Admin Created');
            }
            return $this->returnResult(400, 'Something went wrong');
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