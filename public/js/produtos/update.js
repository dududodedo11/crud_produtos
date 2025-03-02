let nameProduct = document.getElementById('nameProduct');
let quantityProduct = document.getElementById('quantityProduct');
let codeProduct = document.getElementById('codeProduct');
let descriptionProduct = document.getElementById('descriptionProduct');
let btnUpdate = document.getElementById('btnUpdate');

const nameProductInitial = nameProduct.value;
const quantityProductInitial = quantityProduct.value;
const codeProductInitial = codeProduct.value;
const descriptionProductInitial = descriptionProduct.value;

function checkValues() {
    if (nameProduct.value === nameProductInitial &&
        quantityProduct.value === quantityProductInitial &&
        codeProduct.value === codeProductInitial &&
        descriptionProduct.value === descriptionProductInitial) {
        btnUpdate.disabled = true;
    } else {
        btnUpdate.disabled = false;
    }
}

// Adiciona eventos de escuta para os inputs
nameProduct.addEventListener('input', checkValues);
quantityProduct.addEventListener('input', checkValues);
codeProduct.addEventListener('input', checkValues);
descriptionProduct.addEventListener('input', checkValues);

// Inicializa o estado do botão
checkValues();
