<?php 
include "../utils.php";
loadHtmlView('admin/header');
loadHtmlView('admin/navbar');

loadController('Admin/Category');
$category = new Category();
$categories = $category->getCategories();

// p($categories);

?>
<div class="container-fluid">
    <div class="row">

        <?php loadHtmlView('admin/sidebar'); ?>


        <div class="row">
            <div class="col-10">
                <h2>Manage Category</h2>
            </div>
            <div class="col-2">
                <a href="#" data-toggle="modal" data-target="#add_category_modal" class="btn btn-primary btn-sm">Add
                    Category</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Category #</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="category_list">
                    <?php
              foreach($categories as $category){
                ?>
                    <tr>
                        <td><?php echo $category['cat_id']; ?></td>
                        <td><?php echo $category['cat_title']; ?></td>
                        <td><a cid="<?php echo $category['cat_id']; ?>" data-target="#edit_category_modal"
                                data-toggle="modal" class="btn btn-sm btn-info edit-category" style="color:#fff;"><i
                                    class="fas fa-pencil-alt"></i></a>&nbsp;<a cid="<?php echo $category['cat_id']; ?>"
                                class="btn btn-sm btn-danger delete-category" style="color:#fff;"><i
                                    class="fas fa-trash-alt"></i></a></td>
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
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-category-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="cat_title" class="form-control" placeholder="Enter Brand Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary add-category">Add Category</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!--Edit category Modal -->
<div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-category-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="e_cat_id">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="e_cat_title" class="form-control"
                                    placeholder="Enter Brand Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary edit-category-btn">Update Category</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<script src="<?php echo getJSScript('admin/category'); ?>"></script>

<?php loadHtmlView('admin/footer'); ?>