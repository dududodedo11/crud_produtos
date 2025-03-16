<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Helpers\ReceiveUrlParameters;
use Client\Middlewares\VerifyLogin;
use Error;
use Rakit\Validation\Validator;

final class Configuracoes extends Controller
{
    public function __construct()
    {
        // Fazer a verificação de login e caso não houver, redirecionar para a página de login.
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);
    }

    public function index(string|null $parameter)
    {
        // Enviar se o usuário está autheticado na API ou não.
        $user_api_bling = isset($_SESSION['bling_auth']) ? true : false;

        // Chamar a view de configurações.
        $this->view("users.configuracoes", [
            "user_api_bling" => $user_api_bling
        ]);
    }

    public function apiBling()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_api_bling", $dataForm['csrf_token'] ?? [])) {
                $validator = new Validator();

                $validator->addValidator('unique', new UniqueRuleRakit);

                $validator->setMessages(require "lang/pt.php");

                $validation = $validator->make($dataForm, [
                    "client_id" => "required",
                    "client_secret" => "required",
                ]);

                $validation->setAliases([
                    "client_id" => "Client ID",
                    "client_secret" => "Client Secret",
                ]);

                $validation->validate();

                if (!$validation->fails()) {
                    $client_id = urlencode($dataForm['client_id']);
                    $state = bin2hex(random_bytes(16));

                    $urlAuth = "https://www.bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id={$client_id}&state={$state}";

                    $_SESSION['api_bling_auth']['client_secret'] = $dataForm['client_secret'];
                    $_SESSION['api_bling_auth']['client_id'] = $client_id;
                    $_SESSION['api_bling_auth']['state'] = $state;

                    header("Location: {$urlAuth}");
                    exit();
                } else {
                    // Validação falhou.

                    // Retornar uma Sessão com o formulário + erros.
                    $_SESSION['api_bling_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Gerar log "debug".
                    GenerateLog::generateLog("debug", "Validação Rakit de formulário da API Bling falhou", ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll(), "user-id" => $_SESSION['user_logged']['id']]);

                    // Redirecionar novamente à página configurações.
                    header("Location: {$_ENV['APP_URL']}configuracoes");
                }
            } else {
                // Token CSRF inválido.

                // Retornar resposta de erro + formulário.
                $_SESSION['api_bling_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['api_bling_response_invalid_form']['form'] = $dataForm;

                // Gerar log "info".
                GenerateLog::generateLog("info", "Token CSRF inválido em configuracoes/apiBling POST", ["form" => $dataForm, "user-id" => $_SESSION['user_logged']['id']]);

                // Redirecionar novamente à página configurações.
                header("Location: {$_ENV['APP_URL']}configuracoes");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $bling_code = ReceiveUrlParameters::receiveUrlParameters("code") ?? "not_found";
            $bling_state = ReceiveUrlParameters::receiveUrlParameters("state") ?? "not_found";

            if ($bling_code != "not_found" || $bling_state != "not_found") {
                $saved_state = $_SESSION['api_bling_auth']['state'] ?? "not_found";

                if (hash_equals($saved_state, $bling_state)) {
                    $client_id = $_SESSION['api_bling_auth']['client_id'];
                    $client_secret = $_SESSION['api_bling_auth']['client_secret'];

                    $authHeader = base64_encode($client_id . ":" . $client_secret);

                    $data = http_build_query([
                        "grant_type" => "authorization_code",
                        "code" => $bling_code,
                    ]);

                    $url = "https://www.bling.com.br/Api/v3/oauth/token";

                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $data,
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/x-www-form-urlencoded",
                            "Accept: 1.0",
                            "Authorization: Basic " . $authHeader
                        ]
                    ]);

                    $response = curl_exec($curl);

                    curl_close($curl);

                    $result = json_decode($response, true);
                    
                    unset($_SESSION['api_bling_auth']);

                    if(isset($result['access_token'])) {
                        // Temporário:
                        $_SESSION['bling_auth']['access_token'] = $result['access_token'];
                        $_SESSION['bling_auth']['expires_in'] = time() + $result['expires_in'];

                        // Redirecionar novamente à página configurações.
                        header("Location: {$_ENV['APP_URL']}configuracoes");
                    } else {

                        $_SESSION['api_bling_response_incorrect_form'] = "Erro ao autenticar com a API Bling, por favor, revise seus dados e tente novamente";

                        // Gerar log "info".
                        GenerateLog::generateLog("info", "Erro ao autenticar com a API Bling", ["result" => $result, "user-id" => $_SESSION['user_logged']['id']]);

                        // Redirecionar novamente à página configurações.
                        header("Location: {$_ENV['APP_URL']}configuracoes");
                    }
                }
            } else {
                GenerateLog::generateLog("error", "URL sem parâmetros obrigatórios em configuracoes/apiBling GET", ["code" => $bling_code, "state" => $bling_state, "user_id" => $_SESSION['user_logged']['id']]);

                ErrorPage::error404();
            }
        } else {
            // Método não suportado.

            // Gerar log "info".
            GenerateLog::generateLog("info", "Método não suportado em configuracoes/apiBling", ["method" => $_SERVER['REQUEST_METHOD'], "user_id" => $_SESSION['user_logged']['id']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404();
        }
    }
}
