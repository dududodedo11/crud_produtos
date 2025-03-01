let listOption1 = document.getElementById('list-option-1');
let listOption2 = document.getElementById('list-option-2');
let listOption3 = document.getElementById('list-option-3');

function addActiveClass(event) {
    event.target.classList.add('active');
}

function removeActiveClass(event) {
    event.target.classList.remove('active');
}

listOption1.addEventListener('mouseover', addActiveClass);
listOption1.addEventListener('mouseout', removeActiveClass);

listOption2.addEventListener('mouseover', addActiveClass);
listOption2.addEventListener('mouseout', removeActiveClass);

listOption3.addEventListener('mouseover', addActiveClass);
listOption3.addEventListener('mouseout', removeActiveClass);

listOption1.addEventListener('click', function() {
    window.location.href = APP_URL + 'gerador-de-faltas?option=1';
});

listOption2.addEventListener('click', function() {
    window.location.href = APP_URL + 'gerador-de-faltas?option=2';
});

listOption3.addEventListener('click', function() {
    window.location.href = APP_URL + 'gerador-de-faltas?option=3';
});


