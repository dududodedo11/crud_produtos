document.getElementById('ProductsLimit').addEventListener('change', function() {
    const limit = this.value;
    const url = new URL(window.location.href);
    url.searchParams.set('limit', limit);
    window.location.href = url.toString();
});