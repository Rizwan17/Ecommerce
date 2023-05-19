<?php 
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("application/config/constants.php");

function getHttpProtocol(){
    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    }
    else {
        $protocol = 'http://';
    }
    return $protocol;
}


function getStaticAssets($filename){
    return getHttpProtocol() . HOSTNAME . "/" . APP_DIR_NAME . "/application/js/" . $filename;
}

function getJSScript($filename){
    return getHttpProtocol() . HOSTNAME . "/" . APP_DIR_NAME . "/application/js/" . $filename . ".js";
}

function getAbsoluteUrl(){
    return getHttpProtocol() . HOSTNAME . "/" . APP_DIR_NAME;
}

function getStylesheet($filename){
    return getHttpProtocol() . HOSTNAME . "/" . APP_DIR_NAME . "/application/css/" . $filename;
}

function loadModel($model_name){
    require ROOT . "/" . APP_DIR_NAME . "/application/models/" . $model_name . ".php";
}

function loadController($controller_name){
    include_once(ROOT . "/" . APP_DIR_NAME . "/application/controllers/" . $controller_name . ".php");
}

function loadHtmlView($filename){
    include_once(ROOT . "/" . APP_DIR_NAME . "/application/views/" . $filename . ".php");
}

function loadImage($filename){
    return getHttpProtocol() . HOSTNAME . "/" . APP_DIR_NAME . "/product-images/" . $filename;
}

function getHref($absoluteFilePath, $params = null){
    $path = "/" . APP_DIR_NAME . "/" . $absoluteFilePath;
    if($params !== null){
        $param = '?';
        foreach($params as $key => $value){
            $param .=  $key . '=' . $value . '&';
        }
        $param = rtrim($param, "&");
        return str_replace("//", "/", $path.$param);
    }
    return str_replace("//", "/", $path);
}

?>