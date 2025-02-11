<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Models\User;
use Client\Helpers\CSRF;
use Client\Middlewares\VerifyLogin;
use Rakit\Validation\Validator;

final class CadastrarUsuario extends Controller {
    public function __construct() {
        if(VerifyLogin::verify()) {
            header("Location: {$_ENV['APP_URL']}");
        }
    }

    /**
     * Função correspondente a página cadastrar-usuario.
     * Apresenta a página para cadastro.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter) {
        $this->view("users.cadastrar", null);
    }

    /**
     * Função para criar usuários.
     * - Só aceita requisiçãoes POST;
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function create(string|null $parameter) {
        // Verificação para saber se o verbo HTTP é POST;
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            // Receber todos os dados POST, incluindo o formulário.
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // Se existir um token no formulário, ele valida se está correto.
            if($dataForm['csrf_token'] && CSRF::validateCSRFToken("form_create_users", $dataForm['csrf_token'])) {
                // Instanciar a validação (rakit).
                $validator = new Validator;

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                // Montar a validação.
                $validation = $validator->make($dataForm, [
                    "username" => "required|min:5|max:80|unique:users,username",
                    "password" => "required|min:8|max:80"
                ]);

                // Trocar os nomes de campos para o desejado.
                $validation->setAliases([
                    "username" => "nome de usuário",
                    "password" => "senha"
                ]);

                // Fazer a validação.
                $validation->validate();

                // Se não houver falhas, continua o processo.
                if(!$validation->fails()) {
                    // Instanciar a controller users.
                    $user = new User;

                    // Chamar o método para criar um novo usuário.
                    $response = $user->create($dataForm);

                    if($response) {
                        // Redirecionar para a página home, com mensagem de sucesso.
                        $_SESSION['create_users_response_success'] = "Usuário cadastrado com sucesso, por favor, entre na sua conta!";
                        header("Location: {$_ENV['APP_URL']}login");
                    } else {
                        // Redirecionar novamente para o cadastrar-usuario, com mensagem de erro.
                        $_SESSION['create_users_response_error'] = "Erro na criação do usuário, por favor, tente novamente mais tarde";
                        header("Location: {$_ENV['APP_URL']}cadastrar-usuario");
                    }
                } else {
                    // Se a validação falhou, crie uma Sessão com as informções de formulário e erros.
                    $_SESSION['create_users_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Redirecionar novamente à página Cadastrar Usuário.
                    header("Location: {$_ENV['APP_URL']}cadastrar-usuario");
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