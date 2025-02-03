<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;
use Client\Helpers\CSRF;

final class CadastrarUsuario extends Controller {
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
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // Se existir um token no formulário, ele vaalida se está correto.
            if($dataForm['csrf_token'] && CSRF::validateCSRFToken("form_create_users", $dataForm['csrf_token'])) {
                var_dump($dataForm);
            }

            // (Criar o usuário).
        } else {
            // (Redirecionar para alguma mensagem de erro).
            die("Página não encontrada (Verbo HTTP errado)");
        }
    }
}