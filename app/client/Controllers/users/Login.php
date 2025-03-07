<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Helpers\ReceiveUrlParameters;
use Client\Middlewares\VerifyLogin;
use Client\Models\User;
use Rakit\Validation\Validator;

class Login extends Controller {
    public function __construct() {
        // Caso o usuário esteja logado, ele não poderá entrar na página.
        if(VerifyLogin::verify()) {
            header("Location: {$_ENV['APP_URL']}");
        }
    }

    /**
     * Função correspondente a página login.
     * Apresenta a página de login.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter) {
        // Receber o parâmetro "redirect" OU a página inicial.
        $redirect = ReceiveUrlParameters::receiveUrlParameters("redirect") ?? $_ENV['APP_URL'];

        // Se a variável $redirect não for igual a URL base, então, crie a variável de aviso.
        if($redirect != $_ENV['APP_URL']) {
            $_SESSION['login_users_required'] = "Para acessar este recurso, é necessário entrar na sua conta";
        }

        // Chamar a view de login.
        $this->view("users.login", ['redirect' => $redirect]);
    }
    
    /**
     * Função para fazer login no sistema.
     * - Só aceita requisições POST.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function login(string|null $parameter) {
        // Receber a Url que estava o parâmetro "redirect" OU a página login.
        $referer = $_SERVER['HTTP_REFERER'] ?? "{$_ENV['APP_URL']}login";

        // Verificação para saber se o verbo HTTP é POST;
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            // Receber todos os dados POST, incluindo o formulário.
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Receber e guardar o parâmetro "redirect".
            $redirect = $dataForm['redirect'];

            // Validar se o token está correto.
            if(isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_login", $dataForm['csrf_token'] ?? [])) {
                // Instanciar a classe de validação.
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
                            // Senha incorreta.

                            // Criar mensagem de erro.
                            $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                            $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;

                            // Gerar log "debug".
                            GenerateLog::generateLog("debug", "Usuário tentou fazer login, mas a senha está incorreta", null);

                            // Redirecionar novamente à página Login.
                            header("Location: {$referer}");
                        }
                    } else {
                        // Usuário não encontrado.

                        // Criar mensagem de erro.
                        $_SESSION['login_users_response_incorrect_form'] = "Usuário/Senha inválido";
                        $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;

                        // Gerar log "debug".
                        GenerateLog::generateLog("debug", "Usuário tentou fazer login, mas o usuário está incorreto.", null);

                        // Redirecionar novamente à página Login.
                        header("Location: {$referer}");
                    }
                } else {
                    // Validação falhou.

                    // Criar mensagem de erro.
                    $_SESSION['login_users_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Gerar log "info".
                    GenerateLog::generateLog("info", "Usuário tentou fazer login, mas os dados estão inválidos", ['errrors' => $validation->errors()->firstOfAll()]);

                    // Redirecionar novamente à página Login.
                    header("Location: {$referer}");
                }
            } else {
                // Token CSRF inválido.

                // Criar mensagem de erro.
                $_SESSION['login_users_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['login_users_response_invalid_form']['form'] = $dataForm;

                // Gerar log "notice".
                GenerateLog::generateLog("notice", "Usuário tentou fazer login, mas o token CSRF está inválido", ['csrf_token' => $dataForm['csrf_token'] ?? [], 'referer' => $referer]);

                // Redirecionar novamente à página Login.
                header("Location: {$referer}");
            }
        } else {
            // Método não suportado.

            // Gerar log "notice".
            GenerateLog::generateLog("notice", "Método não suportado em login/login", ['method' => $_SERVER['REQUEST_METHOD'], 'referer' => $referer]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }

    /**
     * Faz o logout do usuário.
     * Só aceita o método POST, pois não é uma página de visuaalização.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function delete(string|null $parameter) {
        // Verificar se o método é POST.
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            // Deletar a sessão do usuário.
            unset($_SESSION['user_logged']);

            // Redirecionar para página inicial.
            header("Location: {$_ENV['APP_URL']}");
        } else {
            // Método não suportado.

            // Gerar log "notice".
            GenerateLog::generateLog("notice", "Método não suportado em login/logout", ['method' => $_SERVER['REQUEST_METHOD'], 'user_id' => $_SESSION['user_logged']['id']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }
}