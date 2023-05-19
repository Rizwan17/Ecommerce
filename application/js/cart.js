function addToCart(el){
    const body = document.querySelector('body');
    const loggedIn = body.getAttribute('loggedin');
    if(loggedIn === "true"){
        console.log(true);
        const productId = el.getAttribute('pid');
        addToCartApiCall({ productId });

    }else{
        console.log(false);
        const product = el.dataset.product;
        console.log(product);
        
        saveCartDetailsInLocalStorage(JSON.parse(product));
    }
}