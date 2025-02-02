<?php

namespace Client\Controllers\users;

use Client\Controllers\Services\Controller;

final class CadastrarUsuario extends Controller {
    /**
     * Função correspondente a página cadastrar-usuario.
     * Apresenta a página para cadastro.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter) {
        echo "Cadastrar";
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
            // Cadastrar usuário.
            echo "Cadastrando...";
        } else {
            // (Redirecionar para alguma mensagem de erro).
            die("Página não encontrada (Verbo HTTP errado)");
        }
    }
}