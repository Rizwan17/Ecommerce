<?php
require_once("utils.php");
loadHtmlView("header");
?>
<main></main>
<script src="<?php echo getJSScript("httpRequest"); ?>"></script>
<script>

    async function handleOnlinePayment(){
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        const cm = params.get('cm');
        const payment_status = params.get('st');
        const trx_id = params.get('tx');
        const userCartItems = await fetchUserCartItems();
        const [userId, selectedAddressId, paymode] = cm.split(",");
        const payload = {
            cart: userCartItems.map(item => ({
                productId: item.product_id,
                qty: item.cartQty
            })),
            addressId: selectedAddressId,
            paymode,
            payment_status,
            trx_id
        };

        const resp = await createOrder(payload);
        if(resp.status === 201){
            const orderId = resp?.body?.metaData?.orderId || "";
            location.href = routes.ORDER_SUCCESS + `?orderId=${orderId}`;
        }

    }

    handleOnlinePayment();
	

</script>
