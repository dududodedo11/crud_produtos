<?php

namespace Client\Helpers;
use Client\Views\Services\LoadView;

/**
 * Classe responsável por gerar as páginas de erro.
 * Páginas atuais:
 * - 404;
 * - 500;
 */
class ErrorPage {
    /**
     * Função responsável por gerar a página de erro 404.
     *
     * @param string|null $message É a mensagem de erro.
     * @return void
     */
    public static function error404(string|null $message = null) {
        // Muda o código de resposta HTTP para 404.
        http_response_code(404);

        // Chamar a view de erro 404.
        $view = new LoadView("errors.404", ["message" => $message]);
        $view->loadView();

        // Matar completamente a requisição.
        die();
    }

    /**
     * Função responnsável por gerar a página de erro 500.
     *
     * @param string|null $message É a mensagem de erro.
     * @return void
     */
    public static function error500() {
        // Muda o código de resposta HTTP para 500.
        http_response_code(500);

        // Chamar a view de erro 500.
        $view = new LoadView("errors.500", null);
        $view->loadView();

        // Matar completamente a requisição.
        die();
    }
}