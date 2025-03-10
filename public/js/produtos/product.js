const referer = document.referrer;

const dominio = window.location.hostname;

if(referer.includes(dominio)) {
    const previousLinkPage = document.createElement('a');
    previousLinkPage.innerHTML = '<i class="fa-solid fa-arrow-left"></i> Voltar';
    previousLinkPage.href = referer;
    previousLinkPage.classList.add('btn', 'btn-secondary');
    
    document.getElementById("previousPage").appendChild(previousLinkPage);
}

