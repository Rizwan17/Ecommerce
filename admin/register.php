<?php 
include "../utils.php";

loadHtmlView('admin/header');
loadHtmlView('admin/navbar'); 
?>

<div class="container">
	<div class="row justify-content-center" style="margin:100px 0;">
		<div class="col-md-4">
			<h4>Admin Register</h4>
			<p class="message"></p>
			<form id="admin-register-form">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
			  </div>
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			  </div>
			  <div class="form-group">
			    <label for="cpassword">Confirm Password</label>
			    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-primary register-btn">Register</button>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo getJSScript('admin/register'); ?>"></script>
<?php loadHtmlView('admin/footer'); ?>
