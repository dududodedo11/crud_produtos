<?php

namespace Client\Controllers\gerador_faltas;

use Client\Controllers\Services\Controller;
use Client\Middlewares\VerifyLogin;

class GeradorDeFaltas extends Controller {
    public function __construct() {
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);
    }

    public function index() {
        $this->view("gerador_faltas.index", null);
    }
}