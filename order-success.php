<?php 
require_once("utils.php");
loadHtmlView("header");
?>

<style>
.order-success__container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    text-align: center;
}

h1 {
    font-size: 36px;
    margin-top: 0;
    color: #5da5db;
}

p {
    font-size: 18px;
    margin-bottom: 20px;
    line-height: 1.5;
}

table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
    border-spacing: 0;
    text-align: left;
}

th,
td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f5f5f5;
}

.total {
    font-weight: bold;
}

.order-success__btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #5da5db;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.2s ease-in-out;
}

.order-success__btn:hover {
    background-color: #4691c8;
}
</style>

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
            <tr>
                <td>Product 1</td>
                <td>$10.00</td>
                <td>2</td>
                <td>$20.00</td>
            </tr>
            <tr>
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
            </tr>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td>$95.00</td>
            </tr>
        </tbody>
    </table>
    <a href="<?php echo getAbsoluteUrl(); ?>" class="order-success__btn">Continue Shopping</a>
</div>