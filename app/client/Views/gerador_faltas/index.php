<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <link rel="stylesheet" href="<?= $view->linkAsset("css/gerador_faltas/index.css") ?>">
    <title>Gerador de faltas</title>
</head>

<body>
    <main class="container">
        <div class="d-flex justify-content-center align-items-center flex-column vh-100 vx-100">
            <h1 class="display-3">Bem-vindo ao Gerador de Faltas</h1>
            <h2 class="mb-3">Por favor, escolha uma opção:</h2>
            <ul class="list-group">
                <li class="list-group-item">Criar uma consulta a partir de uma venda (API Bling)</li>
                <li class="list-group-item">Criar uma consulta manualmente</li>
                <li class="list-group-item">Ver uma consulta salva</li>
            </ul>   
        </div>
    </main>

    <?php $view->component("bootstrapjs") ?>
</body>

</html>