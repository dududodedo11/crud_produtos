<?php

namespace Client\Controllers\home;

use Client\Controllers\Services\Controller;

final class Home extends Controller {
    /**
     * Função correspondente a página home.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter) {
        // Carrega a view da página inicial.
        $this->view("home.index", null);
    }
}