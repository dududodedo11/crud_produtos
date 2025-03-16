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

        // Se o usuário não houver autenticado a API do Bling, então, redirecionar para a página de configurações.
        if (!isset($_SESSION['bling_auth'])) {
            // Criar mensagem de informação.
            $_SESSION['api_bling_token_required'] = "Para acessar este recurso, é necessário authenticar sua chave de API.";

            // Redirecionar para a página da configurações.
            header("Location: {$_ENV['APP_URL']}configuracoes#api-bling");
        } else {
            // Se o tempo atual for maior que o tempo de expiração do token da API, então, destruir a sessão do token.
            if(time() > $_SESSION['bling_auth']['expires_in']) {
                // Destruir a sessão do Token API.
                unset($_SESSION['bling_auth']);

                // Criar mensagem de informação.
                $_SESSION['api_bling_token_required'] = "Para acessar este recurso, é necessário authenticar sua chave de API.";

                // Redirecionar para a página da configurações.
                header("Location: {$_ENV['APP_URL']}configuracoes#api-bling");
            };
        }
    }

    public function index(string|null $parameter)
    {
        $this->view("gerador_de_faltas.index", null);
    }
}
