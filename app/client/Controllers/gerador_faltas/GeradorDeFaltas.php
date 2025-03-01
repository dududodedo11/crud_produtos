<?php

namespace Client\Controllers\gerador_faltas;

use Client\Controllers\Services\Controller;
use Client\Helpers\ReceiveGetParameters;
use Client\Middlewares\VerifyLogin;

class GeradorDeFaltas extends Controller
{
    public function __construct()
    {
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);
    }

    /**
     * Carrega a view inicial do gerador de faltas.
     *
     * @param string|null $parameter É o parâmetro que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter)
    {
        $queryParams = ReceiveGetParameters::receiveGetParameters();

        $option = filter_var($queryParams['option'] ?? "", FILTER_SANITIZE_NUMBER_INT);

        if(empty($option)) {
            $this->view("gerador_faltas.index", null);
        } else {
            switch($option) {
                case 1:
                    $this->view("gerador_faltas.option1", null);
                break;

                case 2:
                    $this->view("gerador_faltas.option2", null);
                break;

                case 3:
                    $this->view("gerador_faltas.option3", null);
                break;

                default:
                    $this->view("gerador_faltas.index", null);
                break;
            }
        }
    }
}
