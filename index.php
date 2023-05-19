
<?php

include "utils.php";
loadHtmlView('header');

loadController("Category");
loadController("Product");

$category = new Category();
$product = new Product();
$categories = $category->getCategories();

if(isset($_GET['category']) && !empty($_GET['category'])){
	$products = $product->getProductsByCategory($_GET['category']);
}else{
	$products = $product->getProducts();
}

?>
<?php loadHtmlView('nav-header'); ?>
<main>
	<section class="container">
		<div class="categories">
			<ul><?php include_once("application/views/categories.php"); ?></ul>
		</div>
	</section>

	<section class="container mt-20">
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
			<?php include_once("application/views/products.php"); ?>
		</div>
	</section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="<?php echo getJSScript("httpRequest"); ?>"></script>
















































