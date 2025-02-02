<?php

namespace Client\Helpers;

/**
 * Tranforma a string recebida pela URL em uma string que seja igual a controller Requisitada.
 * Exemplo: "minha-conta" -> "MinhaConta".
 */
class SlugController {
    /**
     * Função prinicipal.
     * Tranforma a string recebida pela URL em uma string que seja igual a controller Requisitada.
     *
     * @param string $slugController (Exemplo de entrada: minha-conta)
     * @return string (Exemplo de saída: MinhaConta)
     */
    public static function slugController(string $slugController):string {
        // Todas as letras em caixa baixa, para não haver erros na hora de Capitalizar.
        $slugController = strtolower($slugController);

        // Trocar "-" por " ", para poder Capitalizar As Palavras.
        $slugController = str_replace("-", " ", $slugController);

        // Capitalizar as palavras.
        $slugController = ucwords($slugController);

        // Trocar " " por "".
        $slugController = str_replace(" ", "", $slugController);

        // Retorna o Slug da Controller.
        return $slugController;
    }
}