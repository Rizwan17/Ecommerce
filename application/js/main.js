const API = {
	LOGIN_API: `${baseUrl}/user/login.php`,
	SIGNUP_API: `${baseUrl}/user/signup.php`,
	LOGOUT_API: `${baseUrl}/user/logout.php`,
	ADD_TO_CART: `${baseUrl}/cart/addToCart.php`,
	CART_DETAILS: `${baseUrl}/cart/getCartDetails.php`,
	ADD_ADDRESS: `${baseUrl}/user/addAddress.php`,
	FETCH_USER_ADDRESS: `${baseUrl}/user/fetchUserAddress.php`
};

const isUserLoggedIn = () => {
	const body = document.querySelector('body');
	const loggedin = body.getAttribute('loggedin');
	return loggedin ? JSON.parse(loggedin) : null;
}

const saveCartDetailsInLocalStorage = (product) => {
	const cart = localStorage.getItem("__cart__");
	let updatedCart = {};
	if(cart){
		const parsedCart = JSON.parse(cart);
		if(parsedCart.hasOwnProperty(product.product_id)){
			parsedCart[product.product_id] = {
				...product,
				cartQty: parsedCart[product.product_id].cartQty + 1
			}
		}else{
			parsedCart[product.product_id] = {
				...product,
				cartQty: 1
			}
		}
		updatedCart = parsedCart;
	}else{
		updatedCart[product.product_id] = { ...product, cartQty: 1 };
	}
	localStorage.setItem("__cart__", JSON.stringify(updatedCart));
}

const getCartDetailsFromLocalStorage = () => {
	const cart = localStorage.getItem('__cart__');
	if(cart){
		const parsedCart = JSON.parse(cart);
		const cartItems = [];
		for(let key in parsedCart){
			cartItems.push(parsedCart[key]);
		}
		return cartItems;
	}
	return [];
}

const removeCartItemFromLocalStorage = (productId) => {
	const cart = localStorage.getItem('__cart__');
	if(cart){
		const parsedCart = JSON.parse(cart);
		delete parsedCart[productId];
		localStorage.setItem('__cart__', JSON.stringify(parsedCart));
	}
}

const renderCartHtml = (cartItems) => {
	const cartItemsId = document.getElementById("cart-items");

	const fragment = document.createDocumentFragment();
	cartItems.forEach(item => {
		const tr = document.createElement('tr');

		const title = document.createElement('td');
		const price = document.createElement('td');
		const quantity = document.createElement('td');
		const finalPrice = document.createElement('td');
		const action = document.createElement('td');
		const qtyDiv = document.createElement('div');
		const qtyIncBtn = document.createElement('button');
		const qtyDecBtn = document.createElement('button');
		const qtyInput = document.createElement('input');
		const removeBtn = document.createElement('button');
		

		qtyDiv.classList.add('quantity');
		qtyIncBtn.textContent = '+';
		qtyInput.disabled = true;
		qtyIncBtn.addEventListener('click', async (e) => {
			qtyIncBtn.disabled = true;
			let q = parseInt(qtyInput.value);
			q += 1;
			if(q > item.product_qty){
				alert('Out of stock');
				return;
			}
			await addToCartApiCall({ productId: item.product_id });
			qtyInput.value = q;
			finalPrice.textContent = item.product_price * parseInt(qtyInput.value);
			qtyIncBtn.disabled = false;
		})
		qtyDecBtn.textContent = '-';
		qtyDecBtn.addEventListener('click', async (e) => {
			qtyDecBtn.disabled = true;
			let q = parseInt(qtyInput.value);
			if(q === 1) return;
			q -= 1;
			await addToCartApiCall({cart: [{productId: item.product_id, qty: q}]});
			qtyInput.value = q;
			finalPrice.textContent = item.product_price * parseInt(qtyInput.value);
			qtyDecBtn.disabled = false;
		})
		qtyInput.value = item.cartQty;
		qtyDiv.appendChild(qtyDecBtn);
		qtyDiv.appendChild(qtyInput);
		qtyDiv.appendChild(qtyIncBtn);

		title.textContent = item.product_title;
		price.textContent = item.product_price;
		quantity.appendChild(qtyDiv);
		finalPrice.textContent = item.product_price * item.cartQty;
		removeBtn.textContent = 'X';
		removeBtn.addEventListener('click', (e) => {
			removeCartItemFromLocalStorage(item.product_id);
		});
		action.appendChild(removeBtn);

		tr.appendChild(title);
		tr.appendChild(price);
		tr.appendChild(quantity);
		tr.appendChild(finalPrice);
		tr.appendChild(action);

		fragment.appendChild(tr);
	});

	cartItemsId.appendChild(fragment);
}

const renderAddressHtml = (addresses) => {
	const addressListHtml = document.querySelector(".address-list");

	const fragment = document.createDocumentFragment();
	addresses.forEach(item => {
		const addressDiv = document.createElement('div');
		addressDiv.classList.add('address');
		addressDiv.addEventListener('click',  (e) => {
			const addressesEl = document.querySelectorAll('.address');

			// remove the selected class from all addresses
			addressesEl.forEach(a => a.classList.remove('selected'));
			// add the selected class to the clicked address
			addressDiv.classList.add('selected');

			addressListHtml.setAttribute('delivery-address', JSON.stringify(item));
		})

		const h3 = document.createElement('h3');
		h3.textContent = item.name;

		const p1 = document.createElement('p');
		p1.textContent = item.address;

		const p2 = document.createElement('p');
		p2.textContent = `${item.city} ${item.state}`;

		const p3 = document.createElement('p');
		p3.textContent = item.zip_code;

		addressDiv.appendChild(h3);
		addressDiv.appendChild(p1);
		addressDiv.appendChild(p2);
		addressDiv.appendChild(p3);

		fragment.appendChild(addressDiv);

	});

	addressListHtml.appendChild(fragment);
}

const clearLocalStorageCart = () => {
	localStorage.removeItem('__cart__');
}

const mergeCart = (cart1, cart2) => {
	const cartObject = cart1.concat(cart2).reduce((prev, curr) => {
		prev[curr.product_id] = curr;
		return prev
	}, {});

	return Object.keys(cartObject).map(productId => cartObject[productId]);
}
 
const buildPayload = (payload, method = 'GET') => {
	return {
		method,
		headers: {
			'Content-Type': 'application/json',
		},
		body: payload ? JSON.stringify(payload) : ""
	}
}

const getUrlParams = (paramName) => {
	// Get the current URL
	const url = new URL(window.location.href);

	// Get the search parameters from the URL
	const params = new URLSearchParams(url.search);

	// Access individual parameters
	return JSON.parse(params.get(paramName));
}

















