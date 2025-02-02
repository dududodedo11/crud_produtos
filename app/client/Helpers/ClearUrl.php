<?php

namespace Client\Helpers;

/**
 * Limpa a URl.
 * Feita para ser usada na limpeza da URL da PageController.php
 */
class ClearUrl {
    /**
     * Tira a barra no final de uma string (que seria a url requisitada) e troca os caracteres não aceitos por aceitos.
     *
     * @param string $url Recebe a url bruta.
     * @return string Retorna a url limpa.
     */
    public static function clearUrl(string $url):string {
        // Retira a última barra no final da url, caso haja barra.
        $url = rtrim($url, "/");

        // Caracteres não aceitos.
        $unaccepted_characters = [
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'ü', 'Ý', 'Þ', 'ß',
            'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ý', 'ý', 'þ', 'ÿ', 
            '"', "'", '!', '@', '#', '$', '%', '&', '*', '(', ')', '_', '+', '=', '{', '[', '}', ']', '?', ';', ':', '.', ',', '\\', '\'', '<', '>', '°', 'º', 'ª', ' '
        ];
        
        // Caracteres a serem trocados pelos não aceitos.
        $accepted_characters = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'y', 'b', 's',
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'y', 'y', 'y',
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
        ];

        // Aqui é a troca.
        $url = str_replace(mb_convert_encoding($unaccepted_characters, 'ISO-8859-1', 'UTF-8'), $accepted_characters, mb_convert_encoding($url, 'ISO-8859-1', 'UTF-8'));

        // Ele retorna a url sem barra no final e sem caracteres especiais.
        return $url;
    }
}