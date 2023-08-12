<?php 
include "../utils.php";

loadHtmlView('admin/header');
loadHtmlView('admin/navbar');

loadController('Admin/Order');
$order = new Order();

$resp = $order->getCustomerOrders();
$orders = [];
$order_status = [];
if($resp['status'] === 200){
	$orders = $resp['data']['orders'];
    $order_status = $resp['data']['metaData']['orderStatus'];
}

// p($resp);

?>

<div class="container-fluid">
    <div class="row">

        <?php loadHtmlView('admin/sidebar'); ?>

        <div class="row">
            <div class="col-10">
                <h2>Orders</h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>User #</th>
                        <th>Total Order Amount</th>
                        <th>Order Status</th>
                        <th>Transaction #</th>
                        <th>Payment Status</th>
                        <th>Paymode</th>
                        <th>Created At</th>
                        <th>Updated On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="customer_order_list">
                    <?php foreach($orders as $order){
				?>
                    <tr>
                        <td> <?php echo $order['order_id']; ?> </td>
                        <td> <?php echo $order['user_id']; ?> </td>
                        <td> <?php echo CURRENCY ." ". $order['total_order_amount']; ?> </td>
                        <td> <?php echo $order['order_status']; ?> </td>
                        <td> <?php echo $order['trx_id']; ?> </td>
                        <td> <?php echo $order['p_status']; ?> </td>
                        <td> <?php echo $order['paymode']; ?> </td>
                        <td> <?php echo $order['created_at']; ?> </td>
                        <td> <?php echo $order['updated_at']; ?> </td>
                        <td> <a data-toggle="modal" data-target="#order_details"
                                class="btn btn-sm btn-info order-details" orderid="<?php echo $order['order_id']; ?>"
                                style="color:#fff;"><i class="fas fa-pencil-alt"></i></a></td>
                    </tr>
                    <?php
			} ?>
                </tbody>
            </table>
        </div>
        </main>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Order Item List -->
                <table class="orderlist_item_table">
                    <thead>
                        <tr>
                            <th class="orderlist_item_th">Product ID</th>
                            <th class="orderlist_item_th">Name</th>
                            <!-- <th class="orderlist_item_th">Image</th> -->
                            <th class="orderlist_item_th">Price</th>
                            <th class="orderlist_item_th">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="order-details-table">
                        <!-- Add more rows as needed -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="orderlist_total">Total:</td>
                            <td class="orderlist_total_price"></td>
                            <td class="orderlist_total orderlist_total_qty"></td>
                        </tr>
                    </tfoot>
                </table>

                <div>
                    <?php
                        foreach($order_status as $status){
                            $class = '';
                            if($status['status'] === 'CONFIRMED'){
                                $class = "btn-primary";
                            }else if($status['status'] === "SHIPPED"){
                                $class = "btn-secondary";
                            }else if($status['status'] === "OUT_FOR_DELIVERY"){
                                $class = "btn-success";
                            }else if($status['status'] === "DELIVERED"){
                                $class = "btn-danger";
                            }
                            ?>
                                <button class="btn <?php echo $class; ?> order-status-btn btn-sm" disabled value="<?php echo $status['status']; ?>"><?php echo $status['status']; ?></button>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<script src="<?php echo getJSScript("admin/order"); ?>"></script>

<?php loadHtmlView('admin/footer'); ?>