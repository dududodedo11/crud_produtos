<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Models\User;
use Rakit\Validation\Validator;

class Login extends Controller {
    public function index(string|null $parameter) {
        $this->view("users.login", null);
    }

    public function login(string|null $parameter) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if($dataForm['csrf_token'] && CSRF::validateCSRFToken("form_create_users", $dataForm['csrf_token'])) {
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
                        }
                    } else {
                        $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
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
            }
        } else {
            // (Redirecionar para alguma mensagem de erro 404).
            die("Página não encontrada (Verbo HTTP errado)");
        }

    }
}