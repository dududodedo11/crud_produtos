<?php
// View correspondente a página login.

use Client\Helpers\CSRF;
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <link rel="stylesheet" href="<?php echo $view->linkAsset("css/users/login.css") ?>">
    <title>Login</title>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary justify-content-center vh-100">

    <main class="container form-container">
        <div class="w-100 d-flex justify-content-center mb-3">
            <img src="<?php echo $_ENV['APP_LOGO_PATH'] ?>" alt="Logo do site" class="w-25">
        </div>
        <form action="<?php echo $_ENV['APP_URL'] ?>login/login" method="POST" class="border border-1 p-3 rounded needs-validation">
            <h1 class="h3 fw-normal mb-3 text-center">Entre na sua conta</h1>

            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_login") ?>">

            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($data['redirect']) ?>">

            <div class="mb-3">
                <label for="usernameInput">Nome de usuário:</label>
                <input type="text" name="username" id="usernameInput" placeholder="Insira seu nome de usuário" class="form-control <?php echo isset($_SESSION['login_users_response_invalid_form']['errors']['username']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['login_users_response_invalid_form']['form']['username'] ?? "" ?>">
                <div class="invalid-feedback">
                    <?php echo $_SESSION['login_users_response_invalid_form']['errors']['username'] ?? "" ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="passwordInput">Senha:</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" placeholder="Insira sua senha" class="form-control <?php echo isset($_SESSION['login_users_response_invalid_form']['errors']['password']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['login_users_response_invalid_form']['form']['password'] ?? "" ?>">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="invalid-feedback d-block">
                    <?php echo $_SESSION['login_users_response_invalid_form']['errors']['password'] ?? "" ?>
                </div>
            </div>

            <button type="submit" class="btn rounded bg-primary w-100">Entrar</button>
        </form>

        <p class="text-center mt-1">Não tem conta? <a href="<?php echo $view->linkPage("cadastrar-usuario") ?>">Crie uma aqui</a>.</p>

        <p class="text-danger mt-1 text-center">
            <?php echo $_SESSION['login_users_response_incorrect_form'] ?? "" ?>
        </p>

        <p class="text-success mt-1 text-center">
            <?php echo $_SESSION['create_users_response_success'] ?? "" ?>
        </p>

        <p class="text-info mt-1 text-center">
            <?php echo $_SESSION['login_users_required'] ?? "" ?>
        </p>
    </main>

    <?php
    unset($_SESSION['login_users_response_invalid_form']);
    unset($_SESSION['login_users_response_incorrect_form']);
    unset($_SESSION['create_users_response_success']);
    unset($_SESSION['login_users_required']);
    ?>

    <?php $view->component("bootstrapjs") ?>

    <script src="<?php echo $view->linkAsset("js/users/login.js") ?>"></script>
</body>
</html>
