<?php
// View correspondente a página cadastrar-usuario.

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Cadastrar Usuário</title>
</head>
<body>
    <?php $view->component("navbar") ?>
    <form action="cadastrar-usuario/create" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_create_users") ?>">

        <label for="username">Nome de usuário</label>
        <input type="text" placeholder="Crie seu nome de usuário" name="username"
        value="<?php echo $_SESSION['create_users_response_invalid_form']['form']['username'] ?? "" ?>">
        
        <p><?php echo $_SESSION['create_users_response_invalid_form']['errors']['username'] ?? "" ?></p>

        <br>

        <label for="name">Crie uma senha</label>
        <input type="password" placeholder="Crie sua senha" name="password"
        value="<?php echo $_SESSION['create_users_response_invalid_form']['form']['password'] ?? "" ?>">

        <p><?php echo $_SESSION['create_users_response_invalid_form']['errors']['password'] ?? "" ?></p>

        <br>

        <button type="submit">Cadastrar</button>
    </form>

    <p><?php echo $_SESSION['create_users_response_error'] ?? "" ?></p>

    <?php
    // var_dump($_SESSION['create_users_response_invalid_form'] ?? []);

    // Destruir todas as variáveis de sessão para erros.
    unset($_SESSION['create_users_response_error']);
    unset($_SESSION['create_users_response_invalid_form']);
    ?>
</body>
</html>