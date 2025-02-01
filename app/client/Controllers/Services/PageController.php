<?php

namespace Client\Controllers\Services;

use Client\Helpers\ClearUrl;
use Client\Helpers\SlugController;
use Client\Controllers\Services\LoadPage;

class PageController {
    private string $url;
    private array $urlArray;

    private string $urlController;
    private string $urlMethod;
    private string $urlId;

    public function __construct() {
        if(!empty(filter_input(INPUT_GET, "url", FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, "url", FILTER_DEFAULT);
            $this->url = ClearUrl::clearUrl($this->url);

            $this->urlArray = explode("/", $this->url, 3);

            $this->urlController = $this->urlArray[0];
            $this->urlController = SlugController::slugController($this->urlController);

            $this->urlMethod = isset($this->urlArray[1]) ? $this->urlArray[1] : "index";
            $this->urlId = isset($this->urlArray[2]) ? $this->urlArray[2] : "";
        } else {
            $this->urlController = "Home";
            $this->urlMethod = "index";
            $this->urlId = "";
        }
    }

    public function loadPage():void {
        $loadPage = new LoadPage();
        $loadPage->loadPage($this->urlController, $this->urlMethod, $this->urlId);
    }
}

