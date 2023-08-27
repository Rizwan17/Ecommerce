<?php 
require_once("utils.php");
loadHtmlView("header");

loadController('Order');
$order = new Order();
$orders = $order->fetchOrderDetails();
$orders_array = $orders['data']['orderDetails'];
// p($orders_array);

?>

<?php include_once("application/views/nav-header.php"); ?>



<div class="order-success__container">
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully processed. Here are the details:</p>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                foreach($orders_array as $order){
                    $total += $order['order_qty'] * $order['purchase_price'];
                    ?>
                        <tr>
                            <td><?php echo $order['product_title']; ?></td>
                            <td><?php echo "Rs. " . $order['purchase_price']; ?></td>
                            <td><?php echo $order['order_qty']; ?></td>
                            <td><?php echo "Rs. ". $order['purchase_price'] * $order['order_qty']; ?></td>
                        </tr>
                    <?php
                }
            ?>
            
            <!-- <tr>
                <td>Product 2</td>
                <td>$15.00</td>
                <td>1</td>
                <td>$15.00</td>
            </tr>
            <tr>
                <td>Product 3</td>
                <td>$20.00</td>
                <td>3</td>
                <td>$60.00</td>
            </tr> -->
            <tr>
                <td colspan="3" class="total">Total</td>
                <td><?php echo "Rs. " . $total; ?></td>
            </tr>
        </tbody>
    </table>
    <a href="<?php echo getAbsoluteUrl(); ?>" class="order-success__btn">Continue Shopping</a>
</div>