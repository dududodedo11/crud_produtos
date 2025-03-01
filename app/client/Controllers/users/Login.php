<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Helpers\ReceiveUrlParameters;
use Client\Middlewares\VerifyLogin;
use Client\Models\User;
use Rakit\Validation\Validator;

class Login extends Controller {
    public function __construct() {
        if(VerifyLogin::verify()) {
            header("Location: {$_ENV['APP_URL']}");
        }
    }

    public function index(string|null $parameter) {
        $queryParams = ReceiveUrlParameters::receiveUrlParameters();

        // A variável $redirect será a parte desejada, ou a página home;
        $redirect = $queryParams['redirect'] ?? $_ENV['APP_URL'];

        // Se a variável $redirect não for igual a URL base, então, crie a variável de aviso.
        if($redirect != $_ENV['APP_URL']) {
            $_SESSION['login_users_required'] = "Para acessar este recurso, é necessário entrar na sua conta";
        }

        // Chamar a view de login.
        $this->view("users.login", ['redirect' => $redirect]);
    }
    
    public function login(string|null $parameter) {
        $referer = $_SERVER['HTTP_REFERER'] ?? "{$_ENV['APP_URL']}login";

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $redirect = $dataForm['redirect'];

            if(isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_login", $dataForm['csrf_token'] ?? [])) {
                $validator = new Validator;

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                // Criar a validação.
                $validation = $validator->make($dataForm, [
                    "username" => "required",
                    "password" => "required"
                ]);

                // Mudar o nome dos campos.
                $validation->setAliases([
                    "username" => "nome de usuário",
                    "password" => "senha"
                ]);

                // Executar a validação.
                $validation->validate();

                if(!$validation->fails()) {
                    // Instanciar a Model de usuario.
                    $user = new User;

                    // Verificar se o usuário existe baseado no nome de usuário.
                    $response = $user->getUser($dataForm['username']);

                    // Se houver resposta, o usuário existe, mas falta verificar a senha.
                    if($response) {
                        // Verificar se a senha está correta.
                        if(password_verify($dataForm['password'], $response['password'])) {
                            // Salvar dados do usuário na sessão.
                            $_SESSION['user_logged']['id'] = $response['id'];
                            $_SESSION['user_logged']['username'] = $response['username'];

                            // Redirecionar à onde o usuário queria ir, ou para a página inicial.
                            header("Location: {$redirect}");
                        } else {
                            $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                            $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;

                            // Redirecionar novamente à página Login.
                            header("Location: {$referer}");
                        }
                    } else {
                        $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                        $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;

                        // Redirecionar novamente à página Login.
                        header("Location: {$referer}");
                    }
                } else {
                    // Se a validação falhou, crie uma Sessão com as informções de formulário e erros.
                    $_SESSION['login_users_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Redirecionar novamente à página Login.
                    header("Location: {$referer}");
                }
            } else {
                // Token CSRF inválido.
                $_SESSION['login_users_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;
                // Redirecionar novamente à página Login.
                header("Location: {$referer}");
            }
        } else {
            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }

    /**
     * Faz o logout do usuário.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function delete(string|null $parameter) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            unset($_SESSION['user_logged']);
            header("Location: {$_ENV['APP_URL']}");
        } else {
            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }
}