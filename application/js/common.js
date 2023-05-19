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
  