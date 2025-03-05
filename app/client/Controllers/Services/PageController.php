<?php

namespace Client\Controllers\Services;

use Client\Helpers\ClearUrl;
use Client\Helpers\SlugController;
use Client\Controllers\Services\LoadPage;

class PageController {
    /** Recebe a url bruta requisitada. @var string */
    private string $url;

    /** Recebe os 3 parâmetros da URL (Controller, Método e ID). @var string */
    private array $urlArray;

    /** Recebe a primeira parte da URl (A controller). @var string */
    private string $urlController;

    /** Recebe a segunda parte da URl (O método). @var string */
    private string $urlMethod;

    /** Recebe a terceira parte da URl (O ID). @var string */
    private string $urlId;

    /**
     * É chamado no index.php.
     * - Ele recebe a URl.
     * - Chama a classe que limpa a URl recebida.
     * - Separa a URL por Controller (1), Metodo (2) e ID (3).
     */
    public function __construct() {
        // Caso haja alguma rota na url.
        if(!empty(filter_input(INPUT_GET, "url", FILTER_DEFAULT))) {
            // Recebe a url e coloca em uma variável.
            $this->url = filter_input(INPUT_GET, "url", FILTER_DEFAULT);

            // Limpa a url.
            $this->url = ClearUrl::clearUrl($this->url);

            // Divide a URL por barras (no máximo 3, pois é o que o site necessita).
            $this->urlArray = explode("/", $this->url, 3);

            // Define a urlController como o primeiro indice do array da URL.
            $this->urlController = $this->urlArray[0];

            // Retorna o slug correto da controller requisitada.
            $this->urlController = SlugController::slugController($this->urlController);

            // Caso não haja um método requisitado (Parte 2 da URl), o padrão é "index".
            $this->urlMethod = isset($this->urlArray[1]) ? $this->urlArray[1] : "index";
            
            // Caso não haja um ID requisitado (Parte 3 da URl), o padrão é "".
            $this->urlId = isset($this->urlArray[2]) ? $this->urlArray[2] : "";
        } else {
            // Caso não haja nenhuma rota na url.

            // A controller padrão é "Home" (página home).
            $this->urlController = "Home";

            // O método padrão é "index".
            $this->urlMethod = "index";

            // O id padrão é "";
            $this->urlId = "";
        }
    }

    /**
     * É chamado no index.php.
     * - Ele chama a classe responsável por chamar as páginas (controllers).
     * - É passado para ele as 3 informações (separadas) da URL, limpas e padronizadas;
     * 
     * @return void
     */
    public function loadPage():void {
        $loadPage = new LoadPage();
        $loadPage->loadPage($this->urlController, $this->urlMethod, $this->urlId);
    }
}

