const CONSTANTS = {
    PROJECT_NAME: 'Ecommerce'
};

// Get the protocol (http or https)
const protocol = window.location.protocol;

// Get the host (domain)
const host = window.location.host;

// Combine the protocol and host
const url = protocol + '//' + host;

console.log(url);

const routes = {
    HOME: `${CONSTANTS.PROJECT_NAME}`,
    LOGIN: `${CONSTANTS.PROJECT_NAME}/login.php`,
    SIGNUP: `${CONSTANTS.PROJECT_NAME}/signup.php`,
    PRODUCT_DETAILS: `${CONSTANTS.PROJECT_NAME}/product-details.php`,
    CART: `${CONSTANTS.PROJECT_NAME}/checkout/cart.php`,
    CHECKOUT: `${CONSTANTS.PROJECT_NAME}/checkout`,
    THANKYOU: `${CONSTANTS.PROJECT_NAME}/thankyou`,
    ORDERS: `${CONSTANTS.PROJECT_NAME}/orders`,
    ORDER_DETAILS: `${CONSTANTS.PROJECT_NAME}/order-details.php`,
    ORDER_SUCCESS: `${CONSTANTS.PROJECT_NAME}/order-success.php`
};

for(let route in routes){
    routes[route] = url + '/' + routes[route].replaceAll(`//`, '/');
}

console.log({ routes });

const api = '/' + CONSTANTS.PROJECT_NAME + '/' + 'api';
const baseUrl = url + api.replaceAll('//', '/');

console.log({ baseUrl });

// admin

const adminUrl = '';

const adminRoutes = {
    HOME: `${CONSTANTS.PROJECT_NAME}/admin/index.php`,
    LOGIN: `${CONSTANTS.PROJECT_NAME}/admin/login.php`,
    REGISTER: `${CONSTANTS.PROJECT_NAME}/admin/register.php`,
    BRANDS: `${CONSTANTS.PROJECT_NAME}/admin/brands.php`,
    CATEGORIES: `${CONSTANTS.PROJECT_NAME}/admin/categories.php`,
    CUSTOMER_ORDERS: `${CONSTANTS.PROJECT_NAME}/admin/customer_orders.php`,
    CUSTOMERS: `${CONSTANTS.PROJECT_NAME}/admin/customers.php`,
    PRODUCTS: `${CONSTANTS.PROJECT_NAME}/admin/products.php`,
}

for(let route in adminRoutes){
    adminRoutes[route] = url + '/' + adminRoutes[route].replaceAll(`//`, '/');
}

console.log({ adminRoutes });

const nonLoggedInRoutes = [
    adminRoutes.LOGIN,
    adminRoutes.REGISTER
];

const adminBaseUrl = url + api.replaceAll('//', '/') + '/admin';

console.log({ adminBaseUrl });
