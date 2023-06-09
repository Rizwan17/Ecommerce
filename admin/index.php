<?php 
include_once("../utils.php");
loadHtmlView("admin/header");

loadController("Admin/Admin");
$admin = new Admin();
$adminData = $admin->getAdminList();
$admins = $adminData['data'];

// echo "<pre>";
// print_r($admins);

?>
 
<?php loadHtmlView("admin/navbar"); ?>

<div class="container-fluid">
  <div class="row">
    
      <?php loadHtmlView('admin/sidebar'); ?>

      <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->

      <h2>Other Admins</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="admin_list">
            <?php
              foreach($admins as $admin){
                ?>
                  <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['name']; ?></td>
                    <td><?php echo $admin['email']; ?></td>
                    <td><?php echo $admin['is_active']; ?></td>
                    <td><a class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a></td>
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

<?php loadHtmlView("admin/footer"); ?>
