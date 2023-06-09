const addCategoryForm = document.getElementById("add-category-form");
const editCategoryForm = document.getElementById("edit-category-form");
const categoryList = document.getElementById("category_list");

const handleAddCategory = async (e) => {
    e.preventDefault();

    const categoryName = document.querySelector('input[name=cat_title]').value;
    try{
        const payload = {
            categoryName
        };
        const resp = await fetch(ADMIN_API.ADD_CATEGORY, buildPayload(payload, 'POST'));
        const jsonResp = await resp.json();
        if(jsonResp.status === 201){
            location.reload();
        }else{
            if(jsonResp.message){
                showToast(jsonResp.message, 'error');
            }
        }
    }catch(error){
        console.log(error);
    }
}

const handleDeleteCategory = async (categoryId) => {
    try{
        const resp = await fetch(ADMIN_API.DELETE_CATEGORY + `?categoryId=${categoryId}`, buildPayload({}, 'DELETE'));
        const jsonResp = await resp.json();
        if(jsonResp.status === 200){
            location.reload();
        }else{
            if(jsonResp.message && jsonResp.message.includes('foreign')){
                showToast('Category already in use', 'error');
            }
        }
    }catch(error){
        console.log(error);
    }
}

const handleEditCategoryForm = async (categoryId) => {
    const categoryName = document.querySelector('input[name=e_cat_title]');
    const categoryInputId = document.querySelector('input[name=e_cat_id]');

    try{
        const resp = await fetch(ADMIN_API.GET_CATEGORY_BY_ID + `?categoryId=${categoryId}`, buildPayload({}, 'DELETE'));
        const jsonResp = await resp.json();
        if(jsonResp.status === 200){
            const { cat_id, cat_title } = jsonResp.body || {};
            categoryName.value = cat_title;
            categoryInputId.value = cat_id;
        }else{
            showToast(jsonResp.message, 'error');
        }

    }catch(error){
        console.log(error);
    }
}
const handleUpdateCategory = async (e) => {
    e.preventDefault();

    const categoryName = document.querySelector('input[name=e_cat_title]').value;
    const categoryId = document.querySelector('input[name=e_cat_id]').value;
    try{
        const payload = {
            categoryName,
            categoryId
        };
        const resp = await fetch(ADMIN_API.UPDATE_CATEGORY, buildPayload(payload, 'PUT'));
        const jsonResp = await resp.json();
        if(jsonResp.status === 201){
            location.reload();
        }else{
            if(jsonResp.message){
                showToast(jsonResp.message, 'error');
            }
        }
    }catch(error){
        console.log(error);
    }
}

addCategoryForm.addEventListener('submit', handleAddCategory);
editCategoryForm.addEventListener('submit', handleUpdateCategory);
categoryList.addEventListener('click', (e) => {
    const el = getTargetElement(e, '.delete-category');
    if(el.classList.contains('delete-category')){
        const categoryId = el.getAttribute('cid');
        handleDeleteCategory(categoryId);
    }
});
categoryList.addEventListener('click', (e) => {
    const el = getTargetElement(e, '.edit-category');
    if(el.classList.contains('edit-category')){
        const categoryId = el.getAttribute('cid');
        handleEditCategoryForm(categoryId);
    }
});