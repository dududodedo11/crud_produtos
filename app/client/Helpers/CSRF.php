<?php

namespace Client\Helpers;

/**
 * Usada para criar e validar tokens CSRF.
 */
class CSRF {
    /**
     * Gera um token CSRF e salva na sessão.
     *
     * @param string $formIdentifier Recebe o nome do formulário
     * @return string Retorna o token de validação.
     */
    public static function generateCSRFToken(string $formIdentifier):string {
        // Cria 32 dígitos para serem usadas na sessão.
        $token = bin2hex(random_bytes(32));

        // Salva o token CSRF na sessão.
        $_SESSION['csrf_tokens'][$formIdentifier] = $token;

        // Retorna o token.
        return $token;
    }

    /**
     * Valida um token CSRF criado.
     *
     * @param string $formIdentifier Recebe o nome do formulário
     * @param string $token Recebe qual o token que estava no formulário.
     * @return boolean Retorna se é ou não verdadeiro.
     */
    public static function validateCSRFToken(string $formIdentifier, string $token):bool {
        // Se existir um valor salvo na sessão E este valor for igual ao valor do token, entra no if.
        if(isset($_SESSION['csrf_tokens'][$formIdentifier]) && hash_equals($_SESSION['csrf_tokens'][$formIdentifier], $token)) {
            // Depois de validado, ele é destruído.
            unset($_SESSION['csrf_tokens'][$formIdentifier]);

            // Retorna que o token é verdadeiro.
            return true;
        } else {
            // Retorna que o token é falso.
            return false;
        }
    }
}