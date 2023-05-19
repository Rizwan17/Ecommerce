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
            <div class="col">
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
    renderAddressHtml(userAddress);
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
    if (paymode) {
        const payload = {
            cart: userCartItems.map(item => ({
                productId: item.product_id,
                qty: item.cartQty
            })),
            address: selectedAddress,
            paymode
        };

        console.log({
            payload
        })
    }


}
</script>