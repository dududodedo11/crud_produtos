<?php

namespace Client\Controllers\gerador_de_faltas;

use Client\Controllers\Services\Controller;
use Client\Middlewares\VerifyLogin;

final class GeradorDeFaltas extends Controller
{
    public function __construct()
    {
        // Fazer a verificação de login e caso não houver, redirecionar para a página de login.
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);

        if (!isset($_SESSION['bling_auth'])) {
            $_SESSION['api_bling_token_required'] = "Para acessar este recurso, é necessário authenticar sua chave de API.";
            header("Location: {$_ENV['APP_URL']}configuracoes#api-bling");
        } else {
            if(time() > $_SESSION['bling_auth']['expires_in']) {
                unset($_SESSION['bling_auth']);

                $_SESSION['api_bling_token_required'] = "Para acessar este recurso, é necessário authenticar sua chave de API.";

                header("Location: {$_ENV['APP_URL']}configuracoes#api-bling");
            };
        }
    }

    public function index(string|null $parameter)
    {
        echo "Certo!";
    }
}
