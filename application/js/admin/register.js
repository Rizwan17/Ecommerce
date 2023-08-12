const adminRegister = async (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("cpassword").value;

    if(name !== "" && email !== "" && password !== ""){
        try{
            const payload = {
                name, email, password
            };
            const resp = await fetch(ADMIN_API.REGISTER_API, buildPayload(payload, 'POST'));
            const jsonResp = await resp.json();
            if(jsonResp.status === 201){
                redirectTo(adminRoutes.LOGIN);
            }else{
                showToast(jsonResp.message, 'error');
            }
        }catch(error){
            console.log(error);
        }
    }else{
        showToast("Enter Name, Email & Password", 'error');
    }
}

const adminRegisterForm = document.getElementById("admin-register-form");
adminRegisterForm.addEventListener('submit', adminRegister)