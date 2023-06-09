const productForm = document.getElementById("add_product_modal");
const productList = document.getElementById("product_list");
const productEditForm = document.getElementById("edit-product-form");

const handleProductForm = async (e) => {
  e.preventDefault();

  const productName = document.querySelector("input[name=product_name]").value;
  const brandId = document.querySelector("select[name=brand_id]").value;
  const categoryId = document.querySelector("select[name=category_id]").value;
  const productDescription = document.querySelector(
    "textarea[name=product_desc]"
  ).value;
  const productQty = document.querySelector("input[name=product_qty]").value;
  const productPrice = document.querySelector(
    "input[name=product_price]"
  ).value;
  const productKeywords = document.querySelector(
    "input[name=product_keywords]"
  ).value;
  const productImage = document.querySelector("input[name=product_image]")
    .files[0];

  const formData = new FormData();
  formData.append("productName", productName);
  formData.append("brandId", brandId);
  formData.append("categoryId", categoryId);
  formData.append("productDescription", productDescription);
  formData.append("productQty", productQty);
  formData.append("productPrice", productPrice);
  formData.append("productKeywords", productKeywords);
  formData.append("productImage", productImage);

  try {
    const resp = await fetch(ADMIN_API.ADD_PRODUCT, {
      method: "POST",
      body: formData,
    });
    const jsonResp = await resp.json();
    if (jsonResp.status === 201) {
      location.reload();
    } else {
      if (jsonResp && jsonResp.body) {
        console.log(jsonResp.body);
        for (let value of jsonResp.body) {
          showToast(value, "error");
        }
      }
    }
  } catch (error) {
    console.log(error);
  }
};

const fetchProductDetails = async (productId) => {
  try {
    const resp = await fetch(
      ADMIN_API.FETCH_PRODUCT_BY_ID,
      buildPayload({ productId }, "POST")
    );
    const jsonResp = await resp.json();
    return jsonResp;
  } catch (er) {
    console.log(er);
  }
};

const handleProductEditForm = (resp) => {
  const productId = document.querySelector("input[name=pid]");
  const productName = document.querySelector("input[name=e_product_name]");
  const brandId = document.querySelector("select[name=e_brand_id]");
  const categoryId = document.querySelector("select[name=e_category_id]");
  const productDescription = document.querySelector(
    "textarea[name=e_product_desc]"
  );
  const productQty = document.querySelector("input[name=e_product_qty]");
  const productPrice = document.querySelector("input[name=e_product_price]");
  const productKeywords = document.querySelector(
    "input[name=e_product_keywords]"
  );
  const productImage = document.querySelector("input[name=e_product_image]");

  const {
    product_title,
    product_cat,
    product_brand,
    product_desc,
    product_id,
    product_image,
    product_keywords,
    product_qty,
    product_price,
  } = resp.body.product;

  const { productImageBaseUrl } = resp.body.metaData;

  productId.value = product_id;
  productName.value = product_title;
  brandId.value = product_brand;
  categoryId.value = product_cat;
  productDescription.value = product_desc;
  productQty.value = product_qty;
  productPrice.value = product_price;
  productKeywords.value = product_keywords;

  document
    .querySelector(".e_image_placeholder")
    .setAttribute("src", productImageBaseUrl + product_image);
};

const handleProductEditFormSubmission = async (e) => {
  e.preventDefault();

  const productId = document.querySelector("input[name=pid]").value;
  const productName = document.querySelector(
    "input[name=e_product_name]"
  ).value;
  const brandId = document.querySelector("select[name=e_brand_id]").value;
  const categoryId = document.querySelector("select[name=e_category_id]").value;
  const productDescription = document.querySelector(
    "textarea[name=e_product_desc]"
  ).value;
  const productQty = document.querySelector("input[name=e_product_qty]").value;
  const productPrice = document.querySelector(
    "input[name=e_product_price]"
  ).value;
  const productKeywords = document.querySelector(
    "input[name=e_product_keywords]"
  ).value;
  const productImage = document.querySelector("input[name=e_product_image]")
    .files[0];

  const formData = new FormData();
  formData.append("productId", productId);
  formData.append("productName", productName);
  formData.append("brandId", brandId);
  formData.append("categoryId", categoryId);
  formData.append("productDescription", productDescription);
  formData.append("productQty", productQty);
  formData.append("productPrice", productPrice);
  formData.append("productKeywords", productKeywords);
  formData.append("productImage", productImage);

  try {
    const resp = await fetch(ADMIN_API.UPDATE_PRODUCT, {
      method: "POST",
      body: formData,
    });
    const jsonResp = await resp.json();
    if (jsonResp.status === 201) {
      location.reload();
    } else {
      if (jsonResp && jsonResp.body) {
        console.log(jsonResp.body);
        for (let value of jsonResp.body) {
          showToast(value, "error");
        }
      }
    }
  } catch (error) {
    console.log(error);
  }
};

const deleteProduct = async (productId) => {
  try {
    const resp = await fetch(
      ADMIN_API.DELETE_PRODUCT + `?productId=${productId}`,
      buildPayload({}, "DELETE")
    );
    const jsonResp = await resp.json();
    if (jsonResp.status === 200) {
      location.reload();
    }else{
      if(jsonResp.message && jsonResp.message.includes("foreign")){
          showToast("Product is already in use", "error");
      }
    }
  } catch (error) {
    console.log(error);
  }
};

productForm.addEventListener("submit", handleProductForm);
productList.addEventListener("click", async (e) => {
  const el = getTargetElement(e, ".edit-product");
  const pid = el.getAttribute("pid");
  const productResp = await fetchProductDetails(pid);
  handleProductEditForm(productResp);
});
productList.addEventListener("click", (e) => {
  const el = getTargetElement(e, ".delete-product");
  const pid = el.getAttribute("pid");
  deleteProduct(pid);
});
productEditForm.addEventListener("submit", handleProductEditFormSubmission);
