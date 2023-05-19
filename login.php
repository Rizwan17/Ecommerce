<?php 
require_once("utils.php");
loadHtmlView("header");
?>
<link rel="stylesheet" href="<?php echo getStylesheet("login-style.css"); ?>" />
<main class="form-signin w-100 m-auto">
    <form id="login-form">
        <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
            <input type="email" class="form-control" id="email" placeholder="name@example.com">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Password</label>
        </div>
        <div class="checkbox mb-3">
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
    </form>
</main>
<script src="<?php echo getJSScript("httpRequest"); ?>"></script>
<script>
async function login(e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const isCartContinue = getUrlParams('isCartContinue');

    try {
        const payload = {
            email,
            password
        };
        const errors = validateUserInput(payload);
        if (errors.length > 0) {
            return;
        }
        const resp = await fetch(API.LOGIN_API, buildPayload(payload, 'POST'));
        const jsonResp = await resp.json();
        console.log({
            jsonResp
        });
        if (resp.status === 200) {
            if (isCartContinue && isCartContinue === true) {
                const cartDetails = getCartDetailsFromLocalStorage();
                const userCartDetails = await fetchUserCartItems();
                const finalCartItems = mergeCart(cartDetails, userCartDetails);
                const addToCartResp = await addToCartApiCall({
                    cart: finalCartItems.map(item => ({
                        productId: item.product_id,
                        qty: item.cartQty
                    }))
                });
                if (addToCartResp.status === 200 || addToCartResp.status === 201) {
                    clearLocalStorageCart();
                    location.href = routes.CART;
                }
            } else {
                location.href = routes.HOME;
            }
        } else {
            showToast('Login Failed', 'error');
        }
    } catch (error) {
        console.log(error);
    }
}

const loginForm = document.getElementById("login-form");
loginForm.addEventListener('submit', (e) => login(e));
</script>