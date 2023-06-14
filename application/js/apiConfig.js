const ADMIN_API = {
    LOGIN_API: `${adminBaseUrl}/login.php`,
    CUSTOMER_ORDERS_API: `${adminBaseUrl}/getCustomerOrders.php`,
	ADD_PRODUCT: `${adminBaseUrl}/product/addProduct.php`,
	UPDATE_PRODUCT: `${adminBaseUrl}/product/updateProduct.php`,
	FETCH_PRODUCT_BY_ID: `${adminBaseUrl}/product/fetchProductDetails.php`,
	DELETE_PRODUCT: `${adminBaseUrl}/product/deleteProductById.php`,
	GET_BRAND_BY_ID: `${adminBaseUrl}/brand/getBrandById.php`,
	ADD_BRAND: `${adminBaseUrl}/brand/addBrand.php`,
	UPDATE_BRAND: `${adminBaseUrl}/brand/updateBrandById.php`,
	DELETE_BRAND: `${adminBaseUrl}/brand/deleteBrandById.php`,
	ADD_CATEGORY: `${adminBaseUrl}/category/addCategory.php`,
	DELETE_CATEGORY: `${adminBaseUrl}/category/deleteCategoryById.php`,
	GET_CATEGORY_BY_ID: `${adminBaseUrl}/category/getCategoryById.php`,
	UPDATE_CATEGORY: `${adminBaseUrl}/category/updateCategoryById.php`,
	FETCH_ORDER_DETAILS_BY_ID: `${adminBaseUrl}/order/fetchOrderDetailsById.php`,
	ADMIN_LOGOUT: `${adminBaseUrl}/logout.php`
};

const buildPayload = (payload, method = 'GET') => {
	return {
		method,
		headers: {
			'Content-Type': 'application/json',
		},
		body: payload ? JSON.stringify(payload) : ""
	}
}

console.log({ ADMIN_API });