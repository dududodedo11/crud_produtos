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

    <p style="color: green"><?php echo $_SESSION['create_users_response_success'] ?? "" ?></p>

    <?php
    unset($_SESSION['create_users_response_success']);
    ?>
</body>
</html>