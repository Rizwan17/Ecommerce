<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Api{

    public $JSON = null;

    function __construct(){
        try{
            $json = file_get_contents('php://input');
            if($json){
                $this->JSON = json_decode($json, true);
            }
        }catch(Exception $e){
            
        }
        
    }

    public function response($result = []){
        $res = [];

        if(array_key_exists('status', $result)){
            $res['status'] = $result['status'];
        }else{
            $res['status'] = 500;
        }

        if(array_key_exists('message', $result)){
            $res['message'] = $result['message'];
        }else{
            if($res['status'] === 500){
                $res['message'] = 'Internal Server Error';
            }else if(
                $res['status'] === 200 ||
                $res['status'] === 201
            ){
                $res['message'] = 'SUCCESS';
            }else{
                $res['message'] = 'FAILURE';
            }
        }

        if(array_key_exists('data', $result)){
            $res['body'] = $result['data'];
        }

        http_response_code($res['status']);
        header('Content-Type: application/json');
        // header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Pragma: no-cache');
        // header('Expires: 0');

        echo json_encode($res);
        exit;
    }

    public function invalidRequestType(){
        $this->response([
            "status" => 400,
            "message" => "Invalid Request Type"
        ]);
    }

    public function validateInput($inputs = []){
        $errors = [];
        foreach($inputs as $key => $value){
            if(empty($inputs[$key])){
                array_push($errors, ucfirst($key) . ' Required');
            }
        }

        if(count($errors) > 0){
            $this->response(['status' => 400, 'message' => 'FAILURE', 'data' => $errors]);
        }
    }
}
?>