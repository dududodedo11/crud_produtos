<?php
// Essa view corresponde à página inicial do site.
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Home</title>
</head>
<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>

    <div class="container">
        <h1 class="mb-3">Página Inicial</h1>
        <h2>Links Úteis:</h2>
        <ul>
            <li><a href="<?php echo $view->linkPage("login") ?>">Login</a></li>
            <li><a href="<?php echo $view->linkPage("cadastrar-usuario") ?>">Cadastrar Usuário</a></li>
            <li><a href="<?php echo $view->linkPage("produtos") ?>">Todos os produtos</a></li>
            <li><a href="<?php echo $view->linkPage("produtos/create") ?>">Novo Produto</a></li>
        </ul>
    </div>

    <?php $view->component("bootstrapjs") ?>
</body>
</html>