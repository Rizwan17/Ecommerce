<?php

// admin routes
$routes = [
    'ADMIN' => [
        'BRANDS' => getAbsoluteUrl() . "/admin/brands.php",
        'CATEGORIES' => getAbsoluteUrl() . "/admin/categories.php",
        "CUSTOMER_ORDERS" => getAbsoluteUrl() . "/admin/customer_orders.php",
        "CUSTOMERS" => getAbsoluteUrl() . "/admin/customers.php",
        "HOME" => getAbsoluteUrl() . "/admin/index.php",
        "INDEX" => getAbsoluteUrl() . "/admin" . "/",
        "LOGIN" => getAbsoluteUrl() . "/admin/login.php",
        "PRODUCTS" => getAbsoluteUrl() . "/admin/products.php",
        "REGISTER" => getAbsoluteUrl() . "/admin/register.php",
    ],
    'USER' => [
        'INDEX' => getAbsoluteUrl(). "/",
        'HOME' => getAbsoluteUrl() . "/index.php",
        'LOGIN' => getAbsoluteUrl() . "/login.php",
        'ORDER_SUCCESS' => getAbsoluteUrl() . "/order-success.php",
        'PRODUCT_DETAILS' => getAbsoluteUrl() . "/product-details.php",
        'SIGNUP' => getAbsoluteUrl() . "/signup.php",
        'CART' => getAbsoluteUrl() . "/checkout/cart.php",
        'CHECKOUT' => getAbsoluteUrl() . "/checkout/index.php",
    ],
];

$admin_non_loggedin_routes = [
    $routes['ADMIN']['LOGIN'],
    $routes['ADMIN']['REGISTER'],
];

$user_non_loggedin_routes = [
    $routes['USER']['INDEX'],
    $routes['USER']['HOME'],
    $routes['USER']['LOGIN'],
    $routes['USER']['ORDER_SUCCESS'],
    $routes['USER']['PRODUCT_DETAILS'],
    $routes['USER']['SIGNUP'],
    $routes['USER']['CART']
];



function getCurrentRoute(){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else  
        $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   

    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
    
    return $url; 
}

?>