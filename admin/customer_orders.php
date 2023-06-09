<?php 
include "../utils.php";

loadHtmlView('admin/header');
loadHtmlView('admin/navbar');

loadController('Admin/Order');
$order = new Order();

$resp = $order->getCustomerOrders();
$orders = [];
if($resp['status'] === 200){
	$orders = $resp['data'];
}

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
                        <th>Transaction #</th>
                        <th>Payment Status</th>
                        <th>Paymode</th>
                        <th>Created At</th>
                        <th>Updated On</th>
                    </tr>
                </thead>
                <tbody id="customer_order_list">
                    <?php foreach($orders as $order){
				?>
                    <tr>
                        <td> <?php echo $order['order_id']; ?> </td>
                        <td> <?php echo $order['user_id']; ?> </td>
                        <td> <?php echo $order['total_order_amount']; ?> </td>
                        <td> <?php echo $order['trx_id']; ?> </td>
                        <td> <?php echo $order['p_status']; ?> </td>
                        <td> <?php echo $order['paymode']; ?> </td>
                        <td> <?php echo $order['created_at']; ?> </td>
                        <td> <?php echo $order['updated_at']; ?> </td>
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
<div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-product-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control"
                                    placeholder="Enter Product Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Brand Name</label>
                                <select class="form-control brand_list" name="brand_id">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <select class="form-control category_list" name="category_id">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Description</label>
                                <textarea class="form-control" name="product_desc"
                                    placeholder="Enter product desc"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="number" name="product_price" class="form-control"
                                    placeholder="Enter Product Price">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Keywords <small>(eg: apple, iphone, mobile)</small></label>
                                <input type="text" name="product_keywords" class="form-control"
                                    placeholder="Enter Product Keywords">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Image <small>(format: jpg, jpeg, png)</small></label>
                                <input type="file" name="product_image" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="add_product" value="1">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary add-product">Add Product</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<?php loadHtmlView('admin/footer'); ?>



<script type="text/javascript" src="./js/customers.js"></script>