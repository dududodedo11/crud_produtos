<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
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
        $this->view("users.login", null);
    }
    
    public function login(string|null $parameter) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_login", $dataForm['csrf_token'] ?? [])) {
                $validator = new Validator;

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                $validation = $validator->make($dataForm, [
                    "username" => "required",
                    "password" => "required"
                ]);

                $validation->setAliases([
                    "username" => "nome de usuário",
                    "password" => "senha"
                ]);

                // Fazer a validação.
                $validation->validate();

                if(!$validation->fails()) {
                    $user = new User;

                    $response = $user->getUser($dataForm['username']);

                    if($response) {
                        if(password_verify($dataForm['password'], $response['password'])) {
                            $_SESSION['user_logged']['id'] = $response['id'];
                            $_SESSION['user_logged']['username'] = $response['username'];

                            header("Location: {$_ENV['APP_URL']}");
                        } else {
                            $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                            $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;
                            // Redirecionar novamente à página Login.
                            header("Location: {$_ENV['APP_URL']}login");
                        }
                    } else {
                        $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                        $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;
                        // Redirecionar novamente à página Login.
                        header("Location: {$_ENV['APP_URL']}login");
                    }
                } else {
                    // Se a validação falhou, crie uma Sessão com as informções de formulário e erros.
                    $_SESSION['login_users_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Redirecionar novamente à página Login.
                    header("Location: {$_ENV['APP_URL']}login");
                }
            } else {
                // Token CSRF inválido.
                $_SESSION['login_users_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;
                // Redirecionar novamente à página Login.
                header("Location: {$_ENV['APP_URL']}login");
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