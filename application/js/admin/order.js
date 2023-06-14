const customerOrderList = document.getElementById("customer_order_list");

const handleOrderDetails = async (orderId) => {
    try{
        const resp = await fetch(ADMIN_API.FETCH_ORDER_DETAILS_BY_ID + `?orderId=${orderId}`, buildPayload({}, 'POST'));
        const jsonResp = await resp.json();
        if(jsonResp.status === 200){
            const orders = jsonResp.body;
            const orderDetailsTable = document.getElementById("order-details-table");
            const fragment = document.createDocumentFragment();

            orderDetailsTable.innerHTML = '';
            let totalPrice = 0, totalQty = 0;
            orders.forEach((order, index) => {

                const tr = document.createElement('tr');
                const tdId = document.createElement('td');
                const tdName = document.createElement('td');
                // const tdImage = document.createElement('td');
                const tdPrice= document.createElement('td');
                const tdQty = document.createElement('td');

                tdId.classList.add('orderlist_item_td');
                tdName.classList.add('orderlist_item_td');
                // tdImage.classList.add('orderlist_item_td');
                tdPrice.classList.add('orderlist_item_td');
                tdQty.classList.add('orderlist_item_td');

                tdId.textContent = order.product_id;
                tdName.textContent = order.product_title;
                // tdImage.textContent = order.product_image;
                tdPrice.textContent = order.purchase_price;
                tdQty.textContent = order.order_qty;

                tr.appendChild(tdId);
                tr.appendChild(tdName);
                // tr.appendChild(tdImage);
                tr.appendChild(tdPrice);
                tr.appendChild(tdQty);

                totalPrice += parseFloat(order.purchase_price) * parseFloat(order.order_qty);
                totalQty += parseFloat(order.order_qty);

                fragment.appendChild(tr);

                

            });

            document.querySelector('.orderlist_total_price').textContent = totalPrice;
            document.querySelector('.orderlist_total_qty').textContent = totalQty;

            orderDetailsTable.appendChild(fragment);

        }
    }catch(error){
        console.log(error);
    }
}

customerOrderList.addEventListener('click', (e) => {
    const el = getTargetElement(e, '.order-details');
    if(el.classList.contains('order-details')){
        const orderId = el.getAttribute('orderid');
        handleOrderDetails(orderId);
    }
})