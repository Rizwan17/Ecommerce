<?php
require_once("utils.php");
loadHtmlView("header");

loadController('Product');

$product = new Product();
$products = $product->getProductById($_GET['id']);
$prod = $products[0];
$jsonProduct = htmlspecialchars(json_encode($prod, ENT_QUOTES));

?>

<?php loadHtmlView("nav-header"); ?>
<main>
    <section class="container">
        <div class="product__container">
            <div class="product">
                <div class="product-image">
                    <img src="<?php echo loadImage($prod['product_image']); ?>" alt="Product Image">
                </div>
                <div class="product-info">
                    <h1 class="product-title"><?php echo $prod['product_title']; ?></h1>
                    <h2 class="product-price"><?php echo $prod['product_price']; ?></h2>
                    <p class="product-description"><?php echo $prod['product_desc']; ?></p>
                    <div class="product-buttons">
                        <button data-product="<?php echo $jsonProduct; ?>" pid="<?php echo $prod['product_id']; ?>"
                            onclick="addToCart(this)" class="add-to-cart-button">Add to Cart</button>
                        <button data-product="<?php echo $jsonProduct; ?>" onclick="buyNow(this)"
                            class="buy-now-button">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="<?php echo getStaticAssets("httpRequest.js"); ?>"></script>
<script>
function buyNow(el) {
    const body = document.querySelector('body');
    const loggedIn = body.getAttribute('loggedin');
    if (loggedIn === "true") {
        console.log(true);

    } else {
        console.log(false);
        const product = el.dataset.product;
        console.log(product);

        saveCartDetailsInLocalStorage(JSON.parse(product));
        location.href = routes.CART;
    }
}

function addToCart(el) {
    const body = document.querySelector('body');
    const loggedIn = body.getAttribute('loggedin');
    if (loggedIn === "true") {
        console.log(true);
        const productId = el.getAttribute('pid');
        addToCartApiCall({
            productId
        });

    } else {
        console.log(false);
        const product = el.dataset.product;
        console.log(product);

        saveCartDetailsInLocalStorage(JSON.parse(product));
    }
}
</script>