<?php

namespace Client\Helpers;
use Client\Views\Services\LoadView;

class ErrorPage {
    /**
     * Função responsável por gerar a página de erro 404.
     *
     * @param string|null $message É a mensagem de erro.
     * @return void
     */
    public static function error404(string|null $message = null) {
        http_response_code(404);
        $view = new LoadView("errors.404", ["message" => $message]);
        $view->loadView();
        die();
    }

    /**
     * Função responnsável por gerar a página de erro 500.
     *
     * @param string|null $message É a mensagem de erro.
     * @return void
     */
    public static function error500() {
        http_response_code(500);
        $view = new LoadView("errors.500", null);
        $view->loadView();
        die();
    }
}