let titleCard = document.getElementById('title-card-product');
let titleProduct = document.getElementById('nameProduct');

titleProduct.addEventListener('keyup', function() {
    if(titleProduct.value.length == 0) {
        titleCard.innerHTML = 'Novo Produto';
    } else {
        titleCard.innerHTML = titleProduct.value;
    }
});