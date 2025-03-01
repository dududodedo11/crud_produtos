<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Gerador de faltas</title>
</head>

<body>
    <main class="container">
        <div class="d-flex justify-content-center align-items-center flex-column vh-100 vx-100">
            <div class="w-50">
                <div id="span-link-back" class="row mb-2 fs-5"><a href="<?php echo $_ENV['APP_URL'] . "gerador-de-faltas" ?>"><i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i>Voltar</a></div>

                <h2 class="mb-3">Por favor, digite o número da venda:</h2>

                <form action="" method="get" id="form-number-sell">
                    <input type="number" name="number_sell" id="number_sell" class="form-control mb-3" placeholder="Exemplo: 6592">
                    <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
                </form>
            </div>
        </div>
    </main>

    <?php $view->component("bootstrapjs") ?>

    <script src="<?php echo $view->linkAsset("js/gerador_faltas/option1.js") ?>"></script>
</body>

</html>