<?php

class Model{

    public $con = null;

    public function __construct(){
        $servername = HOST;
        $username = USER;
        $password = PASSWORD;
        $db = DATABASE_NAME;
        // Create connection
        $this->con = mysqli_connect($servername, $username, $password,$db);
    }
    public function mysqli_array_result($con, $sql){
        try{
            $query = mysqli_query($con, $sql);
            if(mysqli_num_rows($query) > 0){
                $result = [];
                while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                    array_push($result, $row);
                }
                return $result;
            }
            return [];
        }catch(Exception $e){
            throw new Error($e->getMessage());
        }
        
    }

    public function returnResult($status = null, $message = null, $data = null){
        $ar = [];
        if($status !== null) $ar['status'] = $status;
        if($message !== null) $ar['message'] = $message;
        if($data !== null) $ar['data'] = $data;
        return $ar;
    }
}

?>