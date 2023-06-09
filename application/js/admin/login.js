const adminLogin = async (e) => {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if(email !== "" && password !== ""){
        try{
            const payload = {
                email, password
            };
            const resp = await fetch(ADMIN_API.LOGIN_API, buildPayload(payload, 'POST'));
            const jsonResp = await resp.json();
            if(jsonResp.status === 200){
                location.href = adminRoutes.HOME;
            }else{
                showToast(jsonResp.message, 'error');
            }
        }catch(error){
            console.log(error);
        }
    }
}

const adminLoginForm = document.getElementById("admin-login-form");
adminLoginForm.addEventListener('submit', adminLogin)