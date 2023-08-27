<?php
require_once("../utils.php");
loadHtmlView("header");
?>

<?php loadHtmlView("nav-header"); ?>
<style>
.confirm-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #ffffff;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.confirm-button:hover {
    background-color: #45a049;
}

.confirm-button:focus {
    outline: none;
}

.confirm-button:active {
    background-color: #3e8e41;
}

.add-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #ffffff;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-button:hover {
    background-color: #0069d9;
}

.add-button:focus {
    outline: none;
}

.add-button:active {
    background-color: #0056b3;
}

.card {
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-content {
    font-size: 14px;
    line-height: 1.5;
}

.card-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #ffffff;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card-button:hover {
    background-color: #0069d9;
}

.card-button:focus {
    outline: none;
}

.card-button:active {
    background-color: #0056b3;
}


.payment-option {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-option label {
    display: inline-block;
    padding-left: 30px;
    position: relative;
    cursor: pointer;
    font-size: 16px;
}

.payment-option label:before {
    content: "";
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid #007bff;
    border-radius: 50%;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
}

.payment-option input[type="radio"]:checked+label:before {
    background-color: #007bff;
}
</style>
<main class="container">
    <section class="address__container">
        <h1>Address Book</h1>
        <h2>Addresses</h2>
        <div class="address-list">
            <!-- address placeholder -->
        </div>
        <div class="row">
            <div class="col cnf-adrs-btn-wrapper">
                <button onclick="confirmAddress(this)" class="confirm-button">Confirm Address</button>
            </div>
            <div class="col">
                <button class="add-button" onclick="showAddressForm(this)">Add New Address</button>
            </div>
        </div>

        <div class="add-address d-none">
            <h2>Add New Address</h2>
            <form id="address-form">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>

                <label for="city">City</label>
                <input type="text" id="city" name="city" required>

                <label for="state">State</label>
                <input type="text" id="state" name="state" required>

                <label for="zip">Zip Code</label>
                <input type="text" id="zip" name="zip" required>

                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>

                <input type="submit" value="Add Address">
            </form>
        </div>
    </section>
    <section class="card selected-address d-none">
        <h2 class="card-title">Delivery Address</h2>
        <div class="card-content address-content">
            <!-- delivery address placeholder -->
        </div>
        <button onclick="editAddress(this)" class="card-button">Edit Address</button>
    </section>

    <section class="card payment__container d-none">
        <h2 class="card-title">Select Payment Method</h2>
        <div class="card-content">

            <div class="payment-option">
                <input type="radio" id="cod" name="payment" value="cod">
                <label for="cod">Cash On Delivery</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="credit-card" name="payment" value="credit-card">
                <label for="credit-card">Credit Card</label>
            </div>

            <div class="payment-option">
                <input type="radio" id="paypal" name="payment" value="paypal">
                <label for="paypal">PayPal</label>
            </div>

            <div class="payment-option">
                <input type="radio" id="stripe" name="payment" value="stripe">
                <label for="stripe">Stripe</label>
            </div>


        </div>

        <button onclick="continuePayment(this)" class="card-button payment-button">Continue to Payment</button>
    </section>
</main>


<script src="<?php echo getJSScript("httpRequest"); ?>"></script>
<script>
const addAddressHtmlBlock = document.querySelector('.add-address');
const paymentContainerHtmlBlock = document.querySelector('.payment__container');
const addressContainerHtmlBlock = document.querySelector('.address__container');
const selectedAddressHtmlBlock = document.querySelector('.selected-address');
const confAddressBtnWrapper = document.querySelector('.cnf-adrs-btn-wrapper');

let selectedAddress;

const showAddressForm = (el) => {
    addAddressHtmlBlock.classList.remove('d-none');
}
const hideAddressForm = () => {
    addAddressHtmlBlock.classList.add('d-none');
}

const confirmAddress = (el) => {
    paymentContainerHtmlBlock.classList.remove('d-none');
    addressContainerHtmlBlock.classList.add('d-none');
    selectedAddressHtmlBlock.classList.remove('d-none');

    const addressList = document.querySelector('.address-list');
    const deliveryAddress = addressList.getAttribute('delivery-address');
    const selectedDeliveryAddress = JSON.parse(deliveryAddress);
    const {
        name,
        address,
        city,
        state,
        zip_code,
        phone_number
    } = selectedDeliveryAddress || {};
    selectedAddress = selectedDeliveryAddress;

    const addressContentHtml = document.querySelector('.address-content');
    const h6 = document.createElement('h6');
    h6.textContent = name;

    const p = document.createElement('p');
    p.textContent = `${address}, ${city}, ${state}, Pin Code: ${zip_code}, Mobile Number: ${phone_number}`;

    addressContentHtml.innerHTML = '';
    addressContentHtml.appendChild(h6);
    addressContentHtml.appendChild(p);

}

const editAddress = (el) => {
    paymentContainerHtmlBlock.classList.add('d-none');
    addressContainerHtmlBlock.classList.remove('d-none');
    selectedAddressHtmlBlock.classList.add('d-none')
}


const getUserAddress = async () => {
    const userAddress = await fetchUserAddress();
    console.log({
        userAddress
    });
    if(userAddress.length){
        renderAddressHtml(userAddress);
    }else{
        confAddressBtnWrapper.classList.add('d-none');
    }
    
}

const getSelectedPaymentOption = () => {
    const paymentOptions = document.getElementsByName('payment');
    let selectedOption;

    for (var i = 0; i < paymentOptions.length; i++) {
        if (paymentOptions[i].checked) {
            selectedOption = paymentOptions[i].value;
            break;
        }
    }

    return selectedOption;
}


const submitAddress = async (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const address = document.getElementById('address').value;
    const city = document.getElementById('city').value;
    const state = document.getElementById('state').value;
    const zip = document.getElementById('zip').value;
    const phone_number = document.getElementById('phone_number').value;

    try {
        const payload = {
            name,
            address,
            city,
            state,
            zip_code: zip,
            phone_number
        };
        const resp = await addAddress(payload);
        if (resp.status === 201) {
            hideAddressForm();
            getUserAddress();
            confAddressBtnWrapper.classList.remove('d-none');
        }
    } catch (e) {
        console.log(e);
    }
}

const addressForm = document.getElementById("address-form");
addressForm.addEventListener('submit', submitAddress);
getUserAddress();

function selectPaymentMethod(element) {
    // Remove the 'selected' class from all payment methods
    const paymentMethods = document.querySelectorAll('.payment-method');
    for (let i = 0; i < paymentMethods.length; i++) {
        paymentMethods[i].classList.remove('selected');
    }
    // Add the 'selected' class to the clicked payment method
    element.classList.add('selected');
}

async function continuePayment(el) {
    //window.location.href = 'order-success.php';
    const paymode = getSelectedPaymentOption();
    const userCartItems = await fetchUserCartItems();
    debugger
    if (paymode === "cod") {
        const payload = {
            cart: userCartItems.map(item => ({
                productId: item.product_id,
                qty: item.cartQty
            })),
            addressId: selectedAddress.id,
            paymode
        };

        const resp = await createOrder(payload);
        if(resp.status === 201){
            const orderId = resp?.body?.metaData?.orderId || "";
            location.href = routes.ORDER_SUCCESS + `?orderId=${orderId}`;
        }
    }else if (paymode === "paypal"){
        const form = document.createElement('form');
        form.action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        form.method = "POST";
        [
            { name: "cmd", value: "_cart" },
            { name: "business", value: "shoppingcart@khanstore.com" },
            { name: "upload", value: "1" }
        ].forEach((field) => {
            const input = document.createElement('input');
            input.type = "hidden";
            input.name = field.name;
            input.value = field.value;
            form.append(input);
        });

        userId = 2
        userCartItems.forEach((item, index) => {
            const input1 = document.createElement('input');
            input1.type = "hidden";
            input1.name = `item_name_${index + 1}`;
            input1.value = item.product_title;

            const input2 = document.createElement('input');
            input2.type = "hidden";
            input2.name = `item_number_${index + 1}`;
            input2.value = index + 1;

            const input3 = document.createElement('input');
            input3.type = "hidden";
            input3.name = `amount_${index + 1}`;
            input3.value = item.product_price / 82.96; // To convert into USD

            const input4 = document.createElement('input');
            input4.type = "hidden";
            input4.name = `quantity_${index + 1}`;
            input4.value = item.cartQty;

            form.append(input1);
            form.append(input2);
            form.append(input3);
            form.append(input4);
        });
        [
            { name: 'return', value: "http://localhost/Ecommerce/online-payment.php" },
            { name: 'notify_url', value: "http://localhost/KhanStore/payment_success.php"  },
            { name: 'cancel_return', value: "http://localhost/KhanStore/cancel.php" },
            { name: 'currency_code', value: "USD" },
            { name: 'custom', value: `${userId},${selectedAddress.id},${paymode}` }
        ].forEach(field => {
            const input = document.createElement('input');
            input.type = "hidden";
            input.name = field.name;
            input.value = field.value;
            form.append(input);
        });

        document.body.appendChild(form);
        form.submit();

        // PayerID=KFL9PZ3TDWU7L
        // st=Completed
        // tx=5D1343032C703860T
        // cc=USD
        // amt=976.36
        // cm=2
        // payer_email=test-buyer%40hello.com
        // payer_id=KFL9PZ3TDWU7L
        // payer_status=VERIFIED
        // first_name=Test
        // last_name=Buyer
        // address_name=Test%20Buyer
        // address_street=1%20Main%20St&address_city=San%20Jose
        // address_state=CA
        // address_country_code=US
        // address_zip=95131
        // residence_country=US
        // txn_id=5D1343032C703860T
        // mc_currency=USD
        // mc_fee=34.56
        // mc_gross=976.36
        // protection_eligibility=ELIGIBLE
        // payment_fee=34.56
        // payment_gross=976.36
        // payment_status=Completed
        // payment_type=instant
        // handling_amount=0.00
        // shipping=0.00
        // item_name1=Samsung%20Galaxy%20S6
        // item_number1=1
        // quantity1=2
        // mc_gross_1=120.54
        // tax1=0.00
        // item_name2=APPLE%20iPhone%2013%20%28Midnight%2C%20128%20GB%29
        // item_number2=2
        // quantity2=1
        // mc_gross_2=855.82
        // tax2=0.00
        // num_cart_items=2
        // txn_type=cart
        // payment_date=2023-08-12T19%3A30%3A34Z
        // receiver_id=DLHDMVCTRJU9Y
        // notify_version=UNVERSIONED
        // custom=2
        // verify_sign=AWOYt-cSjrl.Y20MQX2DDMiFDQxUA9VEDRXb3dLM4qfFDi.NqTt96ZDf
    }


}
</script>