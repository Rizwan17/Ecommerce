<?php

loadModel('Model');

class User_Model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function login($email = null, $password = null){
        try{
            if($email !== null && $password !== null){
                $password = md5($password);
	            $sql = "SELECT `user_id`, `name`, `email` FROM user_info WHERE email = '$email' AND password = '$password'";
                $query = mysqli_query($this->con, $sql);
                if(mysqli_num_rows($query) > 0){
                    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                    $_SESSION['uid'] = $row["user_id"];
                    $_SESSION['name'] = $row["name"];

                    return $this->returnResult(200, "login Success", $row);
                }else{
                    return $this->returnResult(400, "login failed! Incorrect email or password");
                }
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function signup($name = null, $email = null, $password = null){
        try{
            if($name !== null && $email !== null && $password !== null){
                $password = md5($password);
	            $sql = "INSERT INTO `user_info`(`name`, `email`, `password`) VALUES ('$name','$email','$password')";
                $query = mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, 'Account created successfully!');
                }else{
                    return $this->returnResult(400, 'Something went wrong');
                }
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function addAddress(
        $userId = null,
        $name = null,
        $address = null,
        $city = null,
        $state = null,
        $zip_code = null,
        $phone_number = null
    ){
        try{
            if(
                $userId !== null &&
                $name !== null &&
                $address !== null &&
                $city !== null &&
                $state !== null &&
                $zip_code !== null &&
                $phone_number !== null
            ){
                $created_at = date('Y-m-d H:i:s');
                $updated_at = $created_at;
                $sql = "INSERT INTO `delivery_addresses`(`user_id`, `name`, `address`, `city`, `state`, `zip_code`, `phone_number`, `created_at`, `updated_at`) VALUES ('$userId','$name','$address','$city','$state','$zip_code', '$phone_number', '$created_at','$updated_at')";
                $query = mysqli_query($this->con, $sql);
                if(mysqli_affected_rows($this->con) > 0){
                    return $this->returnResult(201, 'Address Added Successfully!');
                }else{
                    return $this->returnResult(500, 'Something went wrong');
                }
            } else {
                return $this->returnResult(500, 'Missing Params');
            }
        }catch(Exception $e){
            $this->returnResult(500, $e->getMessage());
        }

    }

    public function fetchUserAddress($userId = null){
        try{
            if($userId !== null){
                $sql = "SELECT `id`, `name`, `address`, `city` , `state`, `zip_code`, `phone_number` FROM `delivery_addresses` WHERE `user_id` = '$userId'";
                $result = $this->mysqli_array_result($this->con, $sql);
                if(count($result) > 0){
                    return $this->returnResult(200, null, $result);
                }
                return $this->returnResult(200, null, []);
            }else{
                return $this->returnResult(500, 'Missing Params');
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

}