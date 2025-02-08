<?php
// View correspondente a página login.

use Client\Helpers\CSRF;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Login</title>
</head>
<body>
    <?php $view->component("navbar") ?>
    <form action="login/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_login") ?>">

        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" placeholder="Insira seu nome de usuário">

        <br>

        <label for="username">Senha:</label>
        <input type="password" name="password" placeholder="Insira sua senha">

        <button type="submit">Entrar</button>
    </form>
</body>
</html>