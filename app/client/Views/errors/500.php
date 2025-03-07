<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Erro 500</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>

    <div class="container">
        <h1 class="display-2 text-center my-5 text-danger">Erro 500 - Erro interno do Servidor</h1>
        <p class="text-center fs-5">Houve um mau funcionamento no sistema. Por favor, tente acessar essa página mais tarde.</p>
        <p class="text-center text-info">Aviso: O desenvolvedor já foi notificado sobre o erro.</p>

        <hr>

        <h2 class="text-center fs-1 mt-5">Links Úteis:</h2>
        <div class="d-flex justify-content-center">
            <ul>
                <li><a href="<?php echo $view->linkPage("login") ?>">Login</a></li>
                <li><a href="<?php echo $view->linkPage("cadastrar-usuario") ?>">Cadastrar Usuário</a></li>
                <li><a href="<?php echo $view->linkPage("produtos") ?>">Todos os produtos</a></li>
                <li><a href="<?php echo $view->linkPage("produtos/create") ?>">Novo Produto</a></li>
            </ul>
        </div>
    </div>

    <?php $view->component("bootstrapjs") ?>
</body>

</html>