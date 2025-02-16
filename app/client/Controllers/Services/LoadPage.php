<?php

namespace Client\Controllers\Services;

use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;

/**
 * Chama a página desejada.
 * - É chamada em PageController.php.
 * - Ela checa se a página (controller) e método existem.
 * - Caso existam, ela chama eles.
 */
class loadPage {
    /** Recebe o nome da controler requisitda. @var string */
    private string $urlController;

    /** Recebe o nome do método requisitdo. @var string */
    private string $urlMethod;

    /** Recebe o nome do ID requisitdo. @var string */
    private string $urlId;

    /** Recebe o path (caminho) da controller requisitada. @var string */
    private string $classLoad;

    /** Guarda a lista controllers (páginas) disponíveis. @var array */
    private array $listPublicPages = [
        "Home",
        "Produtos",
        "CadastrarUsuario",
        "Login"
    ];

    /** Guarda a lista de pastas de controllers disponíveis. @var array */
    private array $listDirectories = [
        "home",
        "produtos",
        "users"
    ];

    /**
     * Função para definir os atributos e checar se página e controller existem, depois, chama a função que instancia a controller.
     *
     * @param string|null $urlController Recebe o nome da Controller.
     * @param string|null $urlMethod Recebe o nome do método.
     * @param string|null $urlId Recebe o valor do ID.
     * @return void
     */
    public function loadPage(string|null $urlController, string|null $urlMethod, string|null $urlId):void {
        // Aqui, as 3 partes da URL são definidas nos atributos da classe.
        $this->urlController = $urlController;
        $this->urlMethod = $urlMethod;
        $this->urlId = $urlId;

        // Verifica se a página existe na lista de páginas.
        if(!$this->checkIssetPage()) {
            // Caso não exista, gerar um Log simples de notícia.
            GenerateLog::generateLog("notice", "Página requisitada não encontrada", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);
            
            // Matar a requisição aqui.
            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página {$_SERVER['REQUEST_URI']} não encontrada");
        }

        // Verifica se a controller da página requisitada existe.
        if(!$this->checkIssetController()) {
            // Caso não exista, gerar um Log mais sério, pois se a página existe era para a controller existir.
            GenerateLog::generateLog("error", "Controller requisitada não encontrada", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);

            // Matar a requisição aqui.
            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página {$_SERVER['REQUEST_URI']} não encontrada");
        }

        // Chama a função que instancia a controller.
        $this->loadMethod();
    }

    public function loadMethod():void {
        // Instancia a classe da controller requisitdada por meio do path que está em classLoad.
        $methodLoad = new $this->classLoad;

        // Guarda o método requisitado em uma variável simples (fiz isso pois não estava sendo possível chamar o método diretamente em um atributo de classe).
        $method = $this->urlMethod;

        // Se o método existir na controller requisitada, chame ele.
        if(method_exists($methodLoad, $this->urlMethod)) {
            // Método é chamado, agora o fluxo vai para a controler que foi requisitada.
            $methodLoad->$method($this->urlId);
        } else {
            // Se não existir o método, gerar um Log simples de notícia.
            GenerateLog::generateLog("notice", "Método requisitado não encontrado", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página {$_SERVER['REQUEST_URI']} não encontrada");
        }
    }

    /**
     * Função periférica para checar se a página existe na lista de páginas.
     *
     * @return boolean
     */
    private function checkIssetPage():bool {
        // Confere na lista de páginas o nome requisitado.
        if(in_array($this->urlController, $this->listPublicPages)) {
            return true;
        } else {
            return false;
        };
    }

    /**
     * Função periférica para checar se a controller existe na lista de controllers e no path dela.
     *
     * @return boolean
     */
    public function checkIssetController():bool {
        // Checa em todas as pastas de controllers se a controller existe.
        foreach($this->listDirectories as $directory) {
            // Além de fazer a checagem, ela também define a variável que guardará o path da controller.
            $this->classLoad = "\\Client\\Controllers\\$directory\\$this->urlController";

            if(class_exists($this->classLoad)) {
                // Se existir, sai da função e retorne que existe.
                return true;
            }
        }

        // Se chegou até aqui, quer dizer que ela não existe. Retorne falso.
        return false;
    }
}