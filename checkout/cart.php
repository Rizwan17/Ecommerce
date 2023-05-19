<?php
require_once("../utils.php");
loadHtmlView("header");

$checkoutUrl = isset($_SESSION['uid']) ? getHref('/checkout') : getHref('login.php', [ 'isCartContinue' => 'true' ]);
?>

<?php loadHtmlView("nav-header"); ?>
<section class="container">
<div class="cart__container">
	<h1>Shopping Cart</h1>
	<table>
		<thead>
			<tr>
				<th>Product</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody id="cart-items"></tbody>
	</table>
	
	<div>
		<!-- <a href="<?php echo getAbsoluteUrl(); ?>/login.php?checkout=continue" class="checkout__btn">Checkout</a> -->
		<a href="<?php echo $checkoutUrl; ?>" class="checkout__btn">Checkout</a>
	</div>
</section>
<script src="<?php echo getJSScript("httpRequest"); ?>"></script>
<script>
	async function fetchCartItems(){
		const isLoggedIn = isUserLoggedIn();
		const localCartItems = getCartDetailsFromLocalStorage();
		if(isLoggedIn){
			const userCartItems = await fetchUserCartItems();
			//const finalCartItems = mergeCart(localCartItems, userCartItems);
			renderCartHtml(userCartItems);
			// addToCartApiCall({ cart: finalCartItems.map(item => ({productId: item.product_id, qty: item.cartQty})) });
		}else{
			const cartItems = getCartDetailsFromLocalStorage();
			renderCartHtml(cartItems);
		}
		
	}

	fetchCartItems();
</script>
    

