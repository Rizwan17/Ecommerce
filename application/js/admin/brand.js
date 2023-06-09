const brandList = document.getElementById('brand_list');
const addBrandForm = document.getElementById("add-brand-form");
const editBrandForm = document.getElementById("edit-brand-form");


const handleAddBrand = async (e) => {
    e.preventDefault();

    const brandName = document.querySelector('input[name=brand_title]').value;

    try{
        const payload = {
            brandName
        };
        const resp = await fetch(ADMIN_API.ADD_BRAND, buildPayload(payload, 'POST'));
        const jsonResp = await resp.json();

        if(jsonResp.status === 201){
            location.reload();
        }
    }catch(error){
        console.log(error);
    }
}

const handleEditBrand = async (e) => {
    e.preventDefault();

    const brandName = document.querySelector('input[name=e_brand_title]').value;
    const brandId = document.querySelector('input[name=e_brand_id]').value;

    try{
        const payload = {
            brandName,
            brandId
        };
        const resp = await fetch(ADMIN_API.UPDATE_BRAND, buildPayload(payload, 'PUT'));
        const jsonResp = await resp.json();

        if(jsonResp.status === 201){
            location.reload();
        }
    }catch(error){
        console.log(error);
    }
}

const handleBrandDelete = async (brandId) => {
    try{
        const resp = await fetch(ADMIN_API.DELETE_BRAND + `?brandId=${brandId}`, buildPayload({}, 'DELETE'));
        const jsonResp = await resp.json();

        if(jsonResp.status === 200){
            location.reload();
        }else{
            if(jsonResp.message && jsonResp.message.includes("foreign")){
                showToast("Brand is already in use", "error");
            }
        }
    }catch(error){
        console.log(error);
    }
}

const handleBrandEditForm = async (brandId) => {
    const brandName = document.querySelector('input[name=e_brand_title]');
    const brandInput = document.querySelector('input[name=e_brand_id]');


    try{
        const resp = await fetch(ADMIN_API.GET_BRAND_BY_ID + `?brandId=${brandId}`);
        const jsonResp = await resp.json();
        if(jsonResp.status === 200){
            brandName.value = jsonResp.body.brand_title;
            brandInput.value = jsonResp.body.brand_id;
        }
    }catch(error){
        console.log(error);
    }
}

addBrandForm.addEventListener('submit', handleAddBrand);
editBrandForm.addEventListener('submit', handleEditBrand);
brandList.addEventListener('click', (e) => {
    const el = getTargetElement(e, '.edit-brand');
    if(el.classList.contains('edit-brand')){
        const brandId = el.getAttribute('bid');
        handleBrandEditForm(brandId);
    }
    
});
brandList.addEventListener('click', (e) => {
    const el = getTargetElement(e, '.delete-brand');
    if(el.classList.contains('delete-brand')){
        const brandId = el.getAttribute('bid');
        handleBrandDelete(brandId);
    }
});