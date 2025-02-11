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
    if(isset($_SESSION['user_logged'])) {
        ?>
        <p style="color: blue">Olá, <?php echo $_SESSION['user_logged']['username'] ?></p>

        <form action="login/delete" method="POST">
            <button type="submit">Sair da conta</button>
        </form>
        <?php
    }
    ?>



    <?php
    // Destruir todas as variáveis de sessão de mensagens.
    unset($_SESSION['create_users_response_success']);
    ?>
</body>
</html>