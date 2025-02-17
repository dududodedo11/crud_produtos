<?php

namespace Client\Middlewares;

/**
 * Classe responsável por verificar se o usuário está logado.
 */
class VerifyLogin {
    /**
     * Função responsável por redirecionar o usuário para a página de login, caso não esteja logado.
     *
     * @return void
     */
    public static function redirect(string $urlToRedirect):void {
        // Transformar caracteres especiais em caracteres de url.
        $urlToRedirect = urlencode($urlToRedirect);
        
        // Se não existir a sessão de usuário logado, redirecione para a página de login.
        if(!isset($_SESSION['user_logged'])) {
            header("Location: {$_ENV['APP_URL']}login?redirect={$urlToRedirect}");
        }
    }

    /**
     * Função responsável por retornar se o usuário está logado ou não.
     *
     * @return bool
     */
    public static function verify():bool {
        // Se existir a sessão de usuário logado, retorne true (existe).
        if(isset($_SESSION['user_logged'])) {
            return true;
        } else {
            return false;
        }
    }
}