let selectedOrders = [];

async function getOrders(pagina = 1, idLoja = "not_found", idSituacao = "not_found") {
    let appApi = APP_URL + `api-bling/getOrders?pagina=${pagina}&idLoja=${idLoja}&idSituacao=${idSituacao}`;

    try {
        const response = await fetch(appApi, {
            method: 'GET'
        });

        // Verifica se a resposta foi bem-sucedida
        if (!response.ok) {
            throw new Error('Erro na resposta da requisição');
        }

        const data = await response.json();

        return data;
    } catch (error) {
        alert("Erro ao buscar os pedidos.");
        console.log(error);
        // Garante que o carregamento seja ocultado mesmo em erro
        document.getElementById("loading-content-orders").style.display = "none";
    }
}

function insertOrders(pedidos) {
    pedidos.forEach(pedido => {
        let tableRow = document.createElement("tr");

        let checkboxTd = document.createElement("td");
        let checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.classList.add("form-check-input");
        checkbox.value = pedido.id;

        checkboxTd.appendChild(checkbox);
        tableRow.appendChild(checkboxTd);

        if (selectedOrders.includes(checkbox.value)) {
            checkbox.checked = true;
        }

        let numero = document.createElement("td");
        numero.innerHTML = pedido.numero;

        let data = document.createElement("td");
        data.innerHTML = pedido.data;

        let cliente = document.createElement("td");
        cliente.innerHTML = pedido.cliente;

        let valor = document.createElement("td");
        valor.innerHTML = pedido.valor;

        let situacao = document.createElement("td");
        situacao.innerHTML = pedido.situacao;

        tableRow.appendChild(numero);
        tableRow.appendChild(data);
        tableRow.appendChild(cliente);
        tableRow.appendChild(valor);
        tableRow.appendChild(situacao);

        document.getElementById("t-body-orders").appendChild(tableRow);
    });
}

function saveOrdersSelected() {
    const selectedCheckboxes = document.querySelectorAll("#t-body-orders input[type='checkbox']:checked");
    selectedCheckboxes.forEach(checkbox => {
        if (!selectedOrders.includes(checkbox.value)) {
            selectedOrders.push(checkbox.value);
        }
    });

    console.log(selectedOrders);
};


document.getElementById("option-1").addEventListener("click", async function () {
    let pagina = 1;
    let idLoja = "not_found";
    let idSituacao = "not_found";

    document.getElementById("content-0").style.display = "none";
    document.getElementById("content-2").style.display = "block";

    let pedidos = await getOrders();
    insertOrders(pedidos);

    document.getElementById("current-page").innerHTML = pagina;

    // document.getElementById("btn-recover-selected").addEventListener("click", function () {
    //     const selectedCheckboxes = document.querySelectorAll("#t-body-orders input[type='checkbox']:checked");
    //     selectedCheckboxes.forEach(checkbox => {
    //         selectedOrders.push(checkbox.value);
    //     });
    //     console.log("Pedidos selecionados:", selectedOrders);
    // });


    document.getElementById("loading-content-orders").style.display = "none";
    document.getElementById("orders-content").style.display = "block";

    document.getElementById("page-previous-orders").classList.add("disabled");

    document.getElementById("form-check-all").addEventListener("click", function () {
        const checkboxes = document.querySelectorAll("#t-body-orders input[type='checkbox']");
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById("button-orders-bling").addEventListener("click", async function () {
        if (!this.classList.contains("active")) {
            idLoja = 0;
            pedidos = [];
            document.getElementById("loading-content-orders").style.display = "block";
            document.getElementById("orders-content").style.display = "none";

            saveOrdersSelected();

            document.getElementById("t-body-orders").innerHTML = "";
            pedidos = await getOrders(pagina, idLoja, idSituacao);
            insertOrders(pedidos);

            this.classList.add("active");

            document.getElementById("loading-content-orders").style.display = "none";
            document.getElementById("orders-content").style.display = "block";
        } else {
            idLoja = "not_found";
            pedidos = [];
            document.getElementById("loading-content-orders").style.display = "block";
            document.getElementById("orders-content").style.display = "none";

            saveOrdersSelected();

            document.getElementById("t-body-orders").innerHTML = "";
            pedidos = await getOrders(pagina, idLoja, idSituacao);
            insertOrders(pedidos);

            this.classList.remove("active");

            document.getElementById("loading-content-orders").style.display = "none";
            document.getElementById("orders-content").style.display = "block";
        }
    });

    document.getElementById("situacao-order").addEventListener("change", async function () {
        idSituacao = this.value;
        pedidos = [];

        document.getElementById("loading-content-orders").style.display = "block";
        document.getElementById("orders-content").style.display = "none";

        saveOrdersSelected();

        document.getElementById("t-body-orders").innerHTML = "";
        pedidos = await getOrders(pagina, idLoja, idSituacao);
        insertOrders(pedidos);

        document.getElementById("loading-content-orders").style.display = "none";
        document.getElementById("orders-content").style.display = "block";
    });

    document.querySelector("#page-previous-orders a").addEventListener("click", async function () {
        if (pagina == 2) {
            document.getElementById("page-previous-orders").classList.add("disabled");
        }

        if (pagina > 1) {
            pagina--;
            pedidos = [];

            document.getElementById("loading-content-orders").style.display = "block";
            document.getElementById("orders-content").style.display = "none";

            saveOrdersSelected();

            document.getElementById("t-body-orders").innerHTML = "";
            pedidos = await getOrders(pagina, idLoja, idSituacao);
            insertOrders(pedidos);


            document.getElementById("current-page").innerHTML = pagina;

            document.getElementById("loading-content-orders").style.display = "none";
            document.getElementById("orders-content").style.display = "block";
        }
    });

    document.querySelector("#page-next-orders a").addEventListener("click", async function () {
        pagina++;
        pedidos = [];

        document.getElementById("loading-content-orders").style.display = "block";
        document.getElementById("orders-content").style.display = "none";

        saveOrdersSelected();

        document.getElementById("t-body-orders").innerHTML = "";
        pedidos = await getOrders(pagina, idLoja, idSituacao);
        insertOrders(pedidos);


        document.getElementById("current-page").innerHTML = pagina;

        document.getElementById("page-previous-orders").classList.remove("disabled");

        document.getElementById("loading-content-orders").style.display = "none";
        document.getElementById("orders-content").style.display = "block";
    });
});

async function getOrder(idOrder = "not_found") {
    let appApi = APP_URL + `api-bling/getProducts?idOrder=${idOrder}`;

    try {
        const response = await fetch(appApi, {
            method: 'GET'
        });

        // Verifica se a resposta foi bem-sucedida
        if (!response.ok) {
            throw new Error('Erro na resposta da requisição');
        }

        const data = await response.json();

        return data;
    } catch (error) {
        alert("Erro ao buscar os pedidos.");
        console.log(error);
        // Garante que o carregamento seja ocultado mesmo em erro
        document.getElementById("loading-content-orders").style.display = "none";
    }
}

document.getElementById("btn-submit-orders").addEventListener("click", async function () {
    document.getElementById("loading-content-orders").style.display = "block";
    document.getElementById("orders-content").style.display = "none";

    // Garante que os pedidos selecionados estejam atualizados
    saveOrdersSelected();

    const ordersToSearch = await Promise.all(selectedOrders.map(order => getOrder(order)));

    

    document.getElementById("loading-content-orders").style.display = "none";
    document.getElementById("orders-content").style.display = "block";
});