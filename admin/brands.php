<?php 
include "../utils.php";
loadHtmlView('admin/header');
loadHtmlView('admin/navbar');

loadController('Admin/Brand');
$brand = new Brand(); 
$brands = $brand->getBrands();

// p($brands);

?>
<div class="container-fluid">
  <div class="row">
    
    <?php loadHtmlView('admin/sidebar'); ?>


      <div class="row">
      	<div class="col-10">
      		<h2>Manage Brand</h2>
      	</div>
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_brand_modal" class="btn btn-primary btn-sm">Add Brand</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Brand #</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="brand_list">
            <?php 
              foreach($brands as $brand){
                ?>
                  <tr>
                    <td><?php echo $brand['brand_id']; ?></td>
                    <td><?php echo $brand['brand_title']; ?></td>
                    <td><a bid="<?php echo $brand['brand_id']; ?>" data-target="#edit_brand_modal" data-toggle="modal" class="btn btn-sm btn-info edit-brand" style="color:#fff;"><i class="fas fa-pencil-alt"></i></a>&nbsp;<a bid="<?php echo $brand['brand_id']; ?>" class="btn btn-sm btn-danger delete-brand" style="color:#fff;"><i class="fas fa-trash-alt"></i></a></td>
                  </tr> 
                <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add_brand_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-brand-form" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Brand Name</label>
		        		<input type="text" name="brand_title" class="form-control" placeholder="Enter Brand Name">
		        	</div>
        		</div>
        		<div class="col-12">
        			<button type="submit" class="btn btn-primary add-brand">Add Product</button>
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- Edit brand Modal -->
<div class="modal fade" id="edit_brand_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-brand-form" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <input type="hidden" name="brand_id">
              <div class="form-group">
                <label>Brand Name</label>
                <input type="text" name="e_brand_title" class="form-control" placeholder="Enter Brand Name">
              </div>
            </div>
            <input type="hidden" name="e_brand_id" value="1">
            <div class="col-12">
              <button type="submit" class="btn btn-primary edit-brand-btn">Update Brand</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<script src="<?php echo getJSScript('admin/brand'); ?>"></script>

<?php loadHtmlView('admin/footer'); ?>



<!-- <script type="text/javascript" src="./js/brands.js"></script> -->