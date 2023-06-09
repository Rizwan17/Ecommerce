<?php
loadModel('Model');
class Order_Model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function createOrder($userId = null, $cart = [], $addressId = null, $paymode = null){
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
            if($paymode === 'cod'){
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

                $date = date('Y-m-d H:i:s');
                $order_place_sql = "INSERT INTO orders (user_id, total_order_amount, p_status, paymode, created_at, updated_at) VALUES ('$userId', '$total_order_amount', 'pending', 'cod', '$date', '$date')";
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
            }

            $result = $this->returnResult(201, null, $data);
            return $result;
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function fetchOrderDetails($userId = null, $orderId = null){
        try{
            if($userId !== null && $orderId !== null){
                $sql_orders = "SELECT order_details.product_id, order_qty, purchase_price, products.product_title, products.product_image ,order_details.created_at  
                FROM `orders` 
                JOIN order_details ON order_details.order_id = orders.order_id 
                JOIN products ON products.product_id = order_details.product_id
                WHERE orders.order_id = '$orderId'";
                $rows = $this->mysqli_array_result($this->con, $sql_orders);
                if(count($rows) > 0){
                    return $this->returnResult(200, null, $rows);
                }
            }
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }

    public function getCustomerOrders(){
        try{
            $sql = "SELECT `order_id`, `user_id`, `total_order_amount`, `trx_id`, `p_status`, `paymode`, `created_at`, `updated_at` FROM `orders`";
            $rows = $this->mysqli_array_result($this->con, $sql);
            if(count($rows) > 0){
                return $this->returnResult(200, null, $rows);
            }
            return $this->returnResult(200, null, []);
        }catch(Exception $e){
            return $this->returnResult(500, $e->getMessage());
        }
    }
}