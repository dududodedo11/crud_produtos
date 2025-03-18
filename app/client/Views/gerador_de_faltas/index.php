<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Gerador de Faltas</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>

    <main class="container d-none">
        <div id="content-0" style="display: block;">
            <div class="m-auto d-flex justify-content-center align-items-center" style="height: 80vh;">
                <div style="width: 800px;">
                    <h1 class="text-center">Bem vindo! Selecione como deseja continuar:</h1>
                    <div class="row d-flex justify-content-center">
                        <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px; cursor: pointer;" id="option-1">
                            <i class="fa-solid fa-boxes-stacked mb-1" style="font-size: 50px;" id="option-1-icon"></i>
                            <p class="text-center fw-bold" style="font-size: 18px;" id="option-1-text">Gerar a lista de faltas a partir de uma venda</p>
                        </div>
                        <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px; cursor: pointer;" id="option-2">
                            <i class="fa-solid fa-box mb-1" style="font-size: 50px;" id="option-2-icon"></i>
                            <p class="text-center fw-bold" style="font-size: 18px;" id="option-2-text">Gerar a lista de faltas manualmente</p>
                        </div>
                        <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px; cursor: pointer;" id="option-3">
                            <i class="fa-solid fa-floppy-disk mb-1" style="font-size: 50px;" id="option-3-icon"></i>
                            <p class="text-center fw-bold" style="font-size: 18px;" id="option-3-text">Ver listas salvas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-2" style="display: none;">
            <div class="m-auto d-flex justify-content-center">
                <div class="border border-1 rounded p-4 mb-5" style="width: 1100px;">
                    <div id="loading-content-orders" style="display: block;">
                        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
                            <div class="spinner-border text-primary fs-5" style="width: 60px; height: 60px" role="status"></div>
                        </div>
                    </div>

                    <div id="orders-content" style="display: none;">
                        <p class="h2 mb-4">Selecione as vendas desejadas</p>
                        <div class="d-flex justify-content-start align-items-center mb-3">
                            <p class="fw-bold d-inline my-0" style="margin-left: 10px;">Página atual: <span id="current-page" class="text-info"></span></p>

                            <div class="d-inline mx-4" style="width: 2px; height: 40px; background-color: #f7f6f6; border-radius: 10px"></div>

                            <button class="btn btn-primary d-inline" id="button-orders-bling" style="margin-right: 15px; width: 150px;">Somente Bling</button>

                            <select name="situacao_order" id="situacao-order" class="form-select d-inline" style="width: 200px;">
                                <option selected value="not_found">Todos</option>
                                <option value="6">Em Aberto</option>
                                <option value="9">Atendido</option>
                                <option value="12">Cancelado</option>
                            </select>
                        </div>
                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-check-input" id="form-check-all"></th>
                                    <th>Número</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                    <th>Situação</th>
                                </tr>
                            </thead>
                            <tbody id="t-body-orders" class="table-group-divider">

                            </tbody>
                        </table>

                        <nav class="d-flex justify-content-center mt-3">
                            <ul class="pagination">
                                <li class="page-item" id="page-previous-orders"><a href="#content-2" class="page-link">Anterior</a></li>
                                <li class="page-item" id="page-next-orders"><a href="#content-2" class="page-link">Próximo</a></li>
                            </ul>
                        </nav>
                        <div class="w-100 mt-0">
                            <button class="btn btn-primary float-end" style="width: 200px;" id="btn-submit-orders">Buscar produtos <i class="fa-solid fa-bolt" style="margin-left: 5px;"></i></button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>

    <div class="container">
        <div class="m-auto d-flex justify-content-center">
            <div class="border border-1 rounded p-4 mb-5" style="width: 1100px;">
                <div class="orders-2-content" style="display: block;">
                    <div class="order-2-content">
                        <h3 class="h2 mb-4">Gramados Vieira</h3>

                        <div class="d-flex flex-row p-0 mx-2">
                            <div class="bg-success d-flex justify-content-center align-items-center" style="width: 35px; height: 35px; border-radius: 8px; margin-right: 10px !important;">
                                <span class="fw-bold">1</span>
                            </div>

                            <div class="p-0 bg-primary d-flex flex-row" style="height: 35px; width: calc(100% - 45px); border-radius: 8px">
                                <div class="bg-info" style="width: 40%; height: 100%; border-radius: 8px 0 0 8px;">
                                    Nome do produto selcionado texto texto
                                </div>
                                <div class="bg-warning" style="width: 12%; height: 100%">
                                    Código pro
                                </div>
                                <div class="bg-danger" style="width: 8%; height: 100%">
                                    UN pro
                                </div>
                                <div class="bg-secondary" style="width: 15%; height: 100%">
                                    Qtd produo
                                </div>
                                <div class="bg-success" style="width: 20%; height: 100%">
                                    Id poroduto fde
                                </div>
                                <div class="" style="width: 5%; height: 100%;">
                                    Delet
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $view->component("bootstrapjs") ?>
    <script src="<?php echo $view->linkAsset("js/gerador_de_faltas/index/index.js") ?>"></script>
    <script src="<?php echo $view->linkAsset("js/gerador_de_faltas/index/option-1.js") ?>"></script>
</body>

</html>