<?php
// Essa view corresponde à página inicial do site.
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Home</title>
</head>
<body>
    <?php $view->component("navbar") ?>
    <h1>Bem-vindo ao site!</h1>
    <p>Página Home</p>
    <?php
    // Se o usuário for cadastrado com sucesso, imprima a mensagem de sucesso.
    if(isset($_SESSION['create_users_response_success'])) {
        unset($_SESSION['create_users_response_success']);

        ?>
        <p style="color: green;">Usuário criado com sucesso!</p>
        <?php
    }
    ?>
</body>
</html>