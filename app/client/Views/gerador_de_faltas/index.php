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

    <main class="container">
        <div class="m-auto d-flex justify-content-center align-items-center" style="height: 80vh;" id="content-1">
            <div style="width: 800px;">
                <h1 class="text-center">Bem vindo! Selecione como deseja continuar:</h1>
                <div class="row d-flex justify-content-center">
                    <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px;">
                        <i class="fa-solid fa-boxes-stacked mb-1" style="font-size: 50px;"></i>
                        <p class="text-center fw-bold" style="font-size: 18px;">Gerar a lista de faltas a partir de uma venda</p>
                    </div>

                    <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px;">
                        <i class="fa-solid fa-box mb-1" style="font-size: 50px;"></i>
                        <p class="text-center fw-bold" style="font-size: 18px;">Gerar a lista de faltas manualmente</p>
                    </div>

                    <div class="col-auto border border-1 rounded mx-2 d-flex justify-content-center align-items-center flex-column" style="width: 200px; height: 200px;">
                        <i class="fa-solid fa-floppy-disk mb-1" style="font-size: 50px;"></i>
                        <p class="text-center fw-bold" style="font-size: 18px;">Ver listas salvas</p>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php $view->component("bootstrapjs") ?>
</body>

</html>