// Evento para alterar o limite de produtos exibidos.
document.getElementById('ProductsLimit').addEventListener('change', function() {
    const limit = this.value;
    const url = new URL(window.location.href);

    url.searchParams.set('limit', limit);

    window.location.href = url.toString();
});


// Evento para realizar a busca de produtos.
document.getElementById("formSearchProduct").addEventListener('submit', function(event) {
    event.preventDefault();

    const search = document.getElementById('SearchNameProduct').value;
    const url = new URL(window.location.href);

    if(search == ''){
        url.searchParams.delete('search');
    } else {
        url.searchParams.delete('page');
        url.searchParams.set('search', search);
    }

    window.location.href = url.toString();
});