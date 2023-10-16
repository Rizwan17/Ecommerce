<?php
loadModel('Model');
class Order_Model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function getOrderStatus(){
        try{
            $order_status_sql = "SELECT * FROM order_status";
            $order_status_rows = $this->mysqli_array_result($this->con, $order_status_sql);
            return $order_status_rows;
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function getNextOrderStatus($order_status = null){
        $next_status = null;
        try{
            switch($order_status){
                case 'CONFIRMED':
                    $next_status = 'SHIPPED';
                    break;
                case 'SHIPPED':
                    $next_status = 'OUT_FOR_DELIVERY';
                    break;
                case 'OUT_FOR_DELIVERY':
                    $next_status = 'DELIVERED';
                    break;
                case 'DELIVERED':
                    $next_status = 'COMPLETED';
                    break;
                default:
                    $next_status = 'CONFIRMED';
                    break;
            }
            return $next_status;
        }catch(Exception $e){
            return $next_status;
        }
    }
    public function createOrder($userId = null, $cart = [], $addressId = null, $paymode = null, $payment_status = null, $trx_id = null){
        try{
            $data = [];
            $find_user_sql = "SELECT id FROM user_meta_data WHERE user_id = '$userId'";
            $result = $this->mysqli_array_result($this->con, $find_user_sql);
            if(count($result) > 0){
                $update_meta_sql = "UPDATE user_meta_data SET last_used_address_id = '$addressId'";
                mysqli_query($this->con, $update_meta_sql);
                $affected_rows = mysqli_affected_rows($this->con);
                if($affected_rows > 0){
                    $data['metaData'] = [
                        'address' => [
                            'update' => true,
                            'insert' => false
                        ]
                    ];
                }
            }else{
                $insert_meta_sql = "INSERT INTO user_meta_data (user_id, last_used_address_id) VALUES ('$userId', '$addressId')";
                mysqli_query($this->con, $insert_meta_sql);
                $affected_rows = mysqli_affected_rows($this->con);
                if($affected_rows > 0){
                    $data['metaData'] = [
                        'address' => [
                            'update' => false,
                            'insert' => true
                        ]
                    ];
                }
            }
            // if($paymode === 'cod'){
            $total_order_amount = 0;
            $purchase_price = [];
            foreach($cart as $item){
                $productId = $item['productId'];
                $qty = $item['qty'];
                $find_price = "SELECT product_price FROM products WHERE product_id = '$productId'";
                $price_row = $this->mysqli_array_result($this->con, $find_price);
                if((count($price_row)) > 0){
                    $current_price = $price_row[0]['product_price'];
                    $total_order_amount += $current_price * $qty;

                    $purchase_price[$productId] = $current_price;
                }
            }

            if($paymode === 'cod'){
                $payment_status = 'pending';
            }
                
            $date = date('Y-m-d H:i:s');
            $order_place_sql = "INSERT INTO orders (user_id, total_order_amount, trx_id, p_status, paymode, created_at, updated_at) VALUES ('$userId', '$total_order_amount', '$trx_id', '$payment_status', '$paymode', '$date', '$date')";
            mysqli_query($this->con, $order_place_sql);
            $affected_rows = mysqli_affected_rows($this->con);

            if($affected_rows > 0){
                $order_id = mysqli_insert_id($this->con);
                $data['metaData'] = [
                    'orderId' => $order_id
                ];
                // insert into order_details
                $order_item_count = 0;
                foreach($cart as $item){
                    $productId = $item['productId'];
                    $qty = $item['qty'];
                    $prch_price = $purchase_price[$productId];

                    $order_details_sql = "INSERT INTO `order_details`(`order_id`, `product_id`, `order_qty`, `purchase_price`, `created_at`, `updated_at`) VALUES ('$order_id','$productId','$qty','$prch_price','$date','$date')";

                    mysqli_query($this->con, $order_details_sql);
                    if(mysqli_affected_rows($this->con) > 0){
                        $order_item_count++;
                    }
                }

                if($order_item_count === count($cart)){
                    loadModel('Cart_Model');
                    $cartModel = new Cart_Model();
                    $cartModel->removeItemsFromCart($userId, $cart);
                    $data['message'] = 'Order placed successfully';
                }else{
                    $data['message'] = 'Failed to place new orders.';
                }
            }else{
                $data['message'] = 'Failed to place new orders..';
            }
            // }

            $result = $this->returnResult(201, null, $data);
            return $result;
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function fetchOrderDetails($orderId = null){
        try{
            if($orderId !== null){
                $sql_orders = "SELECT orders.order_status, order_details.product_id, order_qty, purchase_price, products.product_title, products.product_image ,order_details.created_at  
                FROM `orders` 
                JOIN order_details ON order_details.order_id = orders.order_id 
                JOIN products ON products.product_id = order_details.product_id
                WHERE orders.order_id = '$orderId'";
                $order_status = $this->getOrderStatus();
                $rows = $this->mysqli_array_result($this->con, $sql_orders);
                $order_status = $rows[0]['order_status'];
                $next_status = $this->getNextOrderStatus($order_status);

                if(count($rows) > 0){
                    return $this->returnResult(200, null, ['orderDetails' => $rows, 'metaData' => ['orderStatus' => $order_status, 'nextStatus' => $next_status]]);
                }
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function getCustomerOrders(){
        try{
            $sql = "SELECT `order_id`, `user_id`, `total_order_amount`, `order_status`, `trx_id`, `p_status`, `paymode`, `created_at`, `updated_at` FROM `orders`";
            $rows = $this->mysqli_array_result($this->con, $sql);
            $order_status_rows = $this->getOrderStatus();
            if(count($rows) > 0){
                return $this->returnResult(200, null, ['orders' => $rows, 'metaData' => [ 'orderStatus' => $order_status_rows ]]);
            }
            return $this->returnResult(200, null, []);
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function fetchUserOrders($userId){
        try{
            if($userId !== null){
                $sql = "SELECT products.product_id, orders.order_id, orders.created_at ,product_title, product_image, purchase_price, order_qty, total_order_amount, order_status, paymode, p_status FROM `orders`";
                $sql .= "JOIN order_details ON orders.order_id = order_details.order_id ";
                $sql .= "JOIN products ON order_details.product_id = products.product_id ";
                $sql .= "WHERE user_id = '$userId'";
                $rows = $this->mysqli_array_result($this->con, $sql);
                if(count($rows) > 0){
                    $orders = [];
                    foreach ($rows as $key => $value) {
                        $orderId = $value['order_id'];
                        if(array_key_exists($orderId, $orders)){
                            array_push($orders[$orderId]['order_items'], $value);
                        }else{
                            $orders[$orderId]['order_items'] = [$value];
                            $orders[$orderId]['paymode'] = $value['paymode'];
                            $orders[$orderId]['p_status'] = $value['p_status'];
                            $orders[$orderId]['total_order_amount'] = $value['total_order_amount'];
                            $orders[$orderId]['created_at'] = $value['created_at'];
                        }
                    }

                    return $this->returnResult(200, null, ['orders' => $orders]);
                }
                return $this->returnResult(200, null, []);
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage()); 
        }
    }

    public function updateOrderStatus($orderId = null, $status = null){
        try{
            $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = '$orderId'";
            mysqli_query($this->con, $sql);
            if(mysqli_affected_rows($this->con) > 0){
                return $this->returnResult(201, "Order updated to ".$status);
            }
            return $this->returnResult(200, "Something went wrong");
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }
}