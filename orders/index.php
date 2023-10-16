<?php 
include "../utils.php";
loadHtmlView('header');
loadHtmlView('nav-header');

loadController('Order');
$order = new Order();
$result = $order->fetchUserOrders();
$user_orders = $result['data']['orders'];
// p($user_orders);


?>
<style>

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .order {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            display: flex;
        }

        .order_product-image {
            max-width: 150px;
            width: 150px;
            margin-right: 20px;
            text-align: center;
        }

        .order_product-image > img{
            max-height: 150px;
            max-width: 150px;
        }

        .product-details {
       
        }

        .product-details h2 {
            font-size: 24px;
            margin: 0;
        }

        .product-details p {
            margin: 0;
        }
    </style>
<main>

    <section class="container mt-20">
    <h1>Orders</h1>
    <?php 
        foreach($user_orders as $key => $user_order){
            $order_id = $key;
            $orders = $user_order['order_items'];

            ?>
                <div>
                    <p>Order Id: <?php echo $order_id; ?></p>
                    <p>Payment Mode: <?php echo $user_order['paymode']; ?></p>
                    <p>Order date: <?php echo $user_order['created_at']; ?></p>
                    <p>Total Order Amount: <?php echo $user_order['total_order_amount']; ?></p>
            <?php

            foreach($orders as $order){
                ?>
                    <div class="order">
                        <div class="order_product-image">
                            <!-- Replace this with the actual product image -->
                            <img src="<?php echo loadImage($order['product_image']);  ?>" alt="Product 1">
                        </div>
                        <div class="product-details">
                            <h2><?php echo $order['product_title']; ?></h2>
                            <p><strong>Quantity:</strong> <?php echo $order['order_qty']; ?></p>
                            <p><strong>Purchase Price:</strong> <?php echo $order['purchase_price']; ?></p>
                            <p><strong>Current Order Status:</strong> <?php echo $order['order_status']; ?></p>
                        </div>
                    </div>
                <?php
            }

            ?>
                </div>
            <?php
        }
    ?>
    <!-- Sample order data (replace with dynamic data) -->
    
    </section>
</main>
