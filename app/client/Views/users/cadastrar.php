<?php
// View correspondente a página cadastrar-usuario.

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <link rel="stylesheet" href="<?php echo $view->linkAsset("css/users/cadastrar.css") ?>">
    <title>Cadastrar Usuário</title>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary justify-content-center vh-100">
    <main class="container form-container">
        <div class="w-100 d-flex justify-content-center mb-3">
            <img src="<?php echo $_ENV['APP_LOGO_PATH'] ?>" alt="Logo do site" class="w-25">
        </div>
        <form action="cadastrar-usuario/create" method="POST" class="border border-1 p-3 rounded needs-validation">
            <h1 class="h3 fw-normal mb-3 text-center">Cadastrar Usuário</h1>
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_create_users") ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Nome de usuário:</label>
                <input type="text" placeholder="Crie seu nome de usuário" name="username" id="username" class="form-control <?php echo isset($_SESSION['create_users_response_invalid_form']['errors']['username']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['create_users_response_invalid_form']['form']['username'] ?? '' ?>">
                <div class="invalid-feedback">
                    <?php echo $_SESSION['create_users_response_invalid_form']['errors']['username'] ?? "" ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Crie uma senha:</label>
                <div class="input-group">
                    <input type="password" placeholder="Crie sua senha" name="password" id="password" class="form-control <?php echo isset($_SESSION['create_users_response_invalid_form']['errors']['password']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['create_users_response_invalid_form']['form']['password'] ?? '' ?>">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="invalid-feedback d-block">
                    <?php echo $_SESSION['create_users_response_invalid_form']['errors']['password'] ?? "" ?>
                </div>
            </div>

            <button type="submit" class="btn rounded bg-primary w-100">Cadastrar</button>
        </form>

        <p class="text-center mt-1">Já tem uma conta? <a href="<?php echo $view->linkPage("login") ?>">Faça o Login aqui</a>.</p>

        <p class="text-danger mt-1 text-center">
            <?php echo $_SESSION['create_users_response_error'] ?? "" ?>
        </p>
    </main>

    <?php
    // Destruir todas as variáveis de sessão para erros.
    unset($_SESSION['create_users_response_error']);
    unset($_SESSION['create_users_response_invalid_form']);
    ?>

    <?php $view->component("bootstrapjs") ?>

    <script src="<?php echo $view->linkAsset("js/users/cadastrar.js") ?>"></script>
</body>

</html>