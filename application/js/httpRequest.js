const addToCartApiCall = async (payload) => {
    try{
        const resp = await fetch(API.ADD_TO_CART, buildPayload(payload, 'PUT'));
        if(resp.status === 201 || resp.status === 200){
            const jsonResp = await resp.json();
            return jsonResp;
        }
    }catch(e){

    }
}

const fetchUserCartItems = async () => {
    try{
        const resp = await fetch(API.CART_DETAILS, buildPayload({}, 'POST'));
        if(resp.status === 200){
            const jsonResp = await resp.json();
            console.log(jsonResp);
            if(jsonResp.body){
                return jsonResp.body;
            }
            return []
        }
    }catch(e){

    }
}

const addAddress = async (payload) => {
    try{
        const resp = await fetch(API.ADD_ADDRESS, buildPayload(payload, 'POST'));
        if(resp.status === 201){
            const jsonResp = await resp.json();
            return jsonResp;
        }
        return {}
    }catch(e){
        console.log(e);
        return {};
    }
}

const fetchUserAddress = async (payload) => {
    try{
        const resp = await fetch(API.FETCH_USER_ADDRESS, buildPayload(payload, 'POST'));
        if(resp.status === 200){
            const jsonResp = await resp.json();
            return jsonResp.body;
        }
        return {}
    }catch(e){
        console.log(e);
        return {};
    }
}

const logout = async () => {
    try{
        const form = document.createElement('form');
        form.action = API.LOGOUT_API;
        form.method = 'GET';

        document.body.appendChild(form);
        form.submit();
    }catch(e){
        console.log(e);
        return {};
    }
}
 
