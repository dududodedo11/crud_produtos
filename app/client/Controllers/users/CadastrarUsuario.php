<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Models\User;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Middlewares\VerifyLogin;
use Rakit\Validation\Validator;

final class CadastrarUsuario extends Controller {
    public function __construct() {
        // Caso o usuário esteja logado, ele não poderá entrar na página.
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
        // Chamar a view de cadastrar-usuario.
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
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Se existir um token no formulário, ele valida se está correto.
            if(isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_create_users", $dataForm['csrf_token'])) {
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
                        // Criar mensagem de sucesso.
                        $_SESSION['create_users_response_success'] = "Usuário cadastrado com sucesso, por favor, entre na sua conta!";

                        // Redirecionar para a página de login.
                        header("Location: {$_ENV['APP_URL']}login");
                    } else {
                        // Model sem resposta.

                        // Criar mensagem de erro.
                        $_SESSION['create_users_response_error'] = "Erro na criação do usuário, por favor, tente novamente mais tarde";

                        // Gerar log de "notice".
                        GenerateLog::generateLog("notice", "Erro na criação de usuário: Model sem resposta.", []);

                        // Redirecionar novamente para o cadastrar-usuario.
                        header("Location: {$_ENV['APP_URL']}cadastrar-usuario");
                    }
                } else {
                    // Validação falhou.

                    // Criar mensagem de erro.
                    $_SESSION['create_users_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Gerar log de "info".
                    GenerateLog::generateLog("info", "Erro de validação de formulário.", ["errors" => $validation->errors()->firstOfAll()]);

                    // Redirecionar novamente para o cadastrar-usuario.
                    header("Location: {$_ENV['APP_URL']}cadastrar-usuario");
                }
            } else {
                // Token CSRF inválido.

                // Criar mensagem de erro.
                $_SESSION['create_users_response_error'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";

                // Gerar log de "notice".
                GenerateLog::generateLog("notice", "Erro de segurança do formulário, token CSRF inválido", ["token" => $dataForm['csrf_token'] ?? null]);

                // Redirecionar novamente para o cadastrar-usuario.
                header("Location: {$_ENV['APP_URL']}cadastrar-usuario");
            }
        } else {
            // Métoto não suportado.

            GenerateLog::generateLog("notice", "Tentativa de acesso a página (POST) de cadastrar-usuario/create com método não suportado.", ['method' => $_SERVER['REQUEST_METHOD']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }
}