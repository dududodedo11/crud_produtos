<?php

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Configurações da conta</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>
    <main class="container">
        <h1 class="mb-4">Configurações da Conta</h1>
        <div style="margin-left: 20px">
            <h2 class="mb-3" id="api-bling">API Bling</h1>
                <div style="margin-left: 20px">
                    <?php if(!$data['user_api_bling']): ?>
                    <p class="h5 mb-3">Por favor, digite seus dados da API:</p>
                    <div class="border border-1 rounded p-3" style="width: 550px;">
                        <form action="<?php echo $_ENV['APP_URL'] . "configuracoes/apiBling" ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_api_bling") ?>">

                            <div class="mb-3">
                                <input type="text" class="form-control <?php echo isset($_SESSION['api_bling_response_invalid_form']['errors']['client_id']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['api_bling_response_invalid_form']['form']['client_id'] ?? "" ?>" placeholder="Client ID" name="client_id">
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['api_bling_response_invalid_form']['errors']['client_id'] ?? "" ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control <?php echo isset($_SESSION['api_bling_response_invalid_form']['errors']['client_secret']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['api_bling_response_invalid_form']['form']['client_secret'] ?? "" ?>" placeholder="Client Secret" name="client_secret">
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['api_bling_response_invalid_form']['errors']['client_secret'] ?? "" ?>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-primary w-100">Authenticar</button>
                            </div>
                        </form>
                        <p class="text-center mt-3 text-danger"><?php echo $_SESSION['api_bling_response_incorrect_form'] ?? "" ?></p>

                        <p class="text-center mt-3 text-info"><?php echo $_SESSION['api_bling_token_required'] ?? "" ?></p>

                    </div>
                    <?php else: ?>
                        <p class="text-success">Você já está autenticado na API Bling!</p>
                    <?php endif; ?>
                </div>
        </div>
    </main>

    <?php $view->component("bootstrapjs") ?>
    
    <?php 
    unset($_SESSION['api_bling_response_invalid_form']);
    unset($_SESSION['api_bling_response_incorrect_form']);
    unset($_SESSION['api_bling_token_required']);
    ?>
</body>

</html>