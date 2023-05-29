

function showToast(message, type) {
    const toastContainer = document.getElementById("toast-container");
  
    const toast = document.createElement("div");
    toast.textContent = message;
    toast.className = `toast ${type}`;
  
    toastContainer.appendChild(toast);
  
    setTimeout(() => {
      toast.style.display = "block";
      setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => {
          toastContainer.removeChild(toast);
        }, 300);
      }, 3000);
    }, 100);
  }

function capitalizeWord(word) {
// Convert the first character to uppercase and concatenate it with the rest of the word
return word.charAt(0).toUpperCase() + word.slice(1);
}

function validateUserInput(inputs = []){
    const errors = [];
    for(let key in inputs){
        if(inputs[key].trim() === ''){
            errors.push(`${capitalizeWord(key)} Required`);
            showToast(`${capitalizeWord(key)} Required`, 'error');
        }
    }

    return errors;
}

const getAppData = async () => {
  try{
    const resp = await fetch(API.FETCH_APP_DATA);
    const jsonResp = await resp.json();
    return jsonResp;
  }catch(error){
    console.log({error});
  }
}

const updateCartCount = async () => {
  const isLoggedIn = isUserLoggedIn();
  const cartCountEl = document.getElementById("cart-counts");
  let cartCount = 0;

  if(isLoggedIn){
    const appData = await getAppData();
    const cart = appData?.body?.cart;
    cartCount = cart?.count || 0;
  }else{
    const cartDetails = getCartDetailsFromLocalStorage();
    cartCount = cartDetails.length;
  }

  if(cartCount != 0){
    cartCountEl.innerHTML = cartCount;
    cartCountEl.style.opacity = 1;
  }else{
    cartCountEl.style.opacity = 0;
  }
  
}
  
updateCartCount();
