<?php

namespace Client\Controllers\Services;

use Client\Helpers\GenerateLog;

class loadPage {
    private string $urlController;
    private string $urlMethod;
    private string $urlId;
    private string $classLoad;

    private array $listPublicPages = [
        "Home",
        "Produtos"
    ];

    private array $listDirectories = [
        "home",
        "produtos"
    ];

    public function loadPage(string|null $urlController, string|null $urlMethod, string|null $urlId):void {
        $this->urlController = $urlController;
        $this->urlMethod = $urlMethod;
        $this->urlId = $urlId;

        if(!$this->checkIssetPage()) {
            GenerateLog::generateLog("notice", "Página requisitada não encontrada", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);
            
            die("Página não encontrada (1)"); // Erro 404?
        }

        if(!$this->checkIssetController()) {
            GenerateLog::generateLog("error", "Controller requisitada não encontrada", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);

            die("Página não encontrada (2)"); // Erro 404 ou 500?
        }

        $this->loadMethod();
    }

    public function loadMethod():void {
        $methodLoad = new $this->classLoad;
        $method = $this->urlMethod;

        if(method_exists($methodLoad, $this->urlMethod)) {
            $methodLoad->$method($this->urlId);
        } else {
            GenerateLog::generateLog("notice", "Método requisitado não encontrado", [
            "urlController" => $this->urlController,
            "urlMethod" => $this->urlMethod,
            "urlId" => $this->urlId
            ]);
            die("Página não encontrada (3)");
        }
    }

    private function checkIssetPage():bool {
        if(in_array($this->urlController, $this->listPublicPages)) {
            return true;
        } else {
            return false;
        };
    }

    public function checkIssetController():bool {
        foreach($this->listDirectories as $directory) {
            $this->classLoad = "\\Client\\Controllers\\$directory\\$this->urlController";

            if(class_exists($this->classLoad)) {
                return true;
            }
        }

        return false;
    }
}